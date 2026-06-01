<?php
Yii::import('zii.widgets.grid.CGridView');
class QActionGridView extends CGridView {
    /*
     * nazewnictwo:
     * id formularza akcji      = {$this->id}-actionGridForm
     * id tr akcji              = {$this->id}-actionGridRow
     * id td zestawu akcji      = {$this->id}-actionSet
     * id div pojedyńczej akcji = {$this->id}-action{nazwa akcji}
     * 
     * $gridActions['submitUrl'] array() np: array('zamowienie/addDetails'));
     * //$gridActions['urlParams'] array - parametru do form-action URL
     * $gridActions['checkBoxHtmlOptions'] array
     * $gridActions['visible'] boolean
     * $gridActions['actions'] array() string
     * $gridActions['actions']['raw'] string tylko wypisuje zawartość zmiennej raw
     * id submit buttona action<Nazwa_akcji>SubmitButton
     * id formularza = actiongridForm<id widgetu>
     * 
     */
    public $gridActions=array();

    public function init()
    {
        $gridActionsDefaults=array(
            'formId'=>$this->id.'-actionGridForm',
            'visible'=>true,
            'submitUrl'=>'',
            'checkBoxValueExpression'=>null,
            //'checkBoxId'=>$this->id.'-mainCheckBox',
            'actionRowHtmlOptions'=>array('id'=>$this->id.'-actionGridRow', 'style'=>'')
        );
        $gridActionsDefaults['checkBoxHtmlOptions']=array(
            //'name'=>$gridActionsDefaults['formId'].'[keyIds]'
            );

        //add user definitions
        if(isset($this->gridActions['checkBoxHtmlOptions']))
            $this->gridActions['checkBoxHtmlOptions']=array_merge($gridActionsDefaults['checkBoxHtmlOptions'], $this->gridActions['checkBoxHtmlOptions']);
        if(isset($this->gridActions['actionRowHtmlOptions']))
                $this->gridActions['actionRowHtmlOptions']=array_merge($gridActionsDefaults['actionRowHtmlOptions'], $this->gridActions['actionRowHtmlOptions']);

        $this->gridActions=array_merge($gridActionsDefaults, $this->gridActions);

        //parse
        $this->gridActions['actionRowHtmlOptions']['style']=$this->gridActions['actionRowHtmlOptions']['style'].';display: '.($this->gridActions['actionRowHtmlOptions']?'table-row;':'none');
        //$this->gridActions['checkBoxHtmlOptions']['name'].='[]';
        
        parent::init();
        $this->initActions();
    }

    public function initActions()
    {
        $actionDefaults=array(
            'visible'=>false,
            'htmlOptions'=>array(
                'id'=>$this->id.'-actionSet',
                'style'),
        );

        if(isset($this->gridActions['actions']))
        foreach($this->gridActions['actions'] as $name=>$action)
        {
            $this->gridActions['actions'][$name]=array_merge(
                    $actionDefaults,
                    array(
                        'label'=>$name,
                        'htmlOptions'=>array(
                            'id'=>$this->id.'-actionSet'.ucfirst($name),
                            'style'=>''
                    )),
                    $action);

            $submitButtonDefaults=array(
                    'submitButtonHtmlOptions'=>array(
                        'encode'=>false,
                        'name'=>$this->gridActions['formId'].'[submitButton]',
                        'onClick'=>'document.getElementById(\''.$this->gridActions['formId'].'\').action=\''.$action['submitUrl'].'\'; document.getElementById(\''.$this->gridActions['formId'].'\').submit();'
                    ),
                );

            //parse
            $this->gridActions['actions'][$name]['htmlOptions']['style']=$this->gridActions['actions'][$name]['htmlOptions']['style'].';visibility: '.($this->gridActions['actions'][$name]['visible']?'visible':'hidden');

            if($action['type']=='button')
            {                   
                $this->gridActions['actions'][$name]=array_merge($submitButtonDefaults, $this->gridActions['actions'][$name]);
            }
            elseif($action['type']=='dropDownList')
                {
                    $dropDownDefaults=array(
                        'selectedValue'=>-1,
                        'dropDownListHtmlOptions'=>array(
                            'id'=>$this->id.'-action'.ucfirst($name),
                            'name'=>$this->id.'['.$name.']',
                        )
                    );

                    $this->gridActions['actions'][$name]=array_merge($submitButtonDefaults, $dropDownDefaults, $this->gridActions['actions'][$name]);
                }
        }
      
    }
      
        protected function initColumns()
        {
                $columnParams = array(
                    'class'=>'CCheckBoxColumn',
                    //'id'=>$this->gridActions['checkBoxId'],
                    'checkBoxHtmlOptions'=>$this->gridActions['checkBoxHtmlOptions'],
                    'value'=>$this->gridActions['checkBoxValueExpression']);
                
            array_unshift($this->columns, $columnParams);

            parent::initColumns();
        }

        public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
                        //echo CHtml::beginForm($this->generateUrl($this->gridActions['submitUrl'], $this->gridActions['urlParams']));
                    echo CHtml::beginForm($this->gridActions['submitUrl'], 'post', array('id'=>$this->gridActions['formId']));
			echo "<table class=\"{$this->itemsCssClass}\">\n";
			$this->renderTableHeader();
			$this->renderTableFooter();
			$this->renderTableBody();
			echo "</table>";
                        echo CHtml::endForm();
		}
		else
			$this->renderEmptyText();
	}

        public function renderGridActions()
        {
            //var_export($this->gridActions['rowHtmlOptions']);die();

            echo CHtml::openTag('tr', $this->gridActions['actionRowHtmlOptions']).CHtml::openTag('td', array('colspan'=>count($this->columns)));
            echo CHtml::hiddenField('actionGridId', $this->id);
            if(isset($this->gridActions['actions']))
            {
            foreach($this->gridActions['actions'] as $name=>$action)
            {
                echo CHtml::openTag('div', $action['htmlOptions']);
                switch($action['type'])
                {
                    case    'dropDownList': echo CHtml::dropDownList($name, $action['selectedValue'], $action['data'], $action['dropDownListHtmlOptions']);
                    case    'button':       echo CHtml::button($action['label'], (isset($action['submitButtonHtmlOptions'])?$action['submitButtonHtmlOptions']:array('id'=>'action'.ucfirst($name).'SubmitButton')));
                        break;

                    default:            echo $action['value'];
                        break;
                }
                echo '</div>';
            }
            }
            
        }

        public function renderTableFooter()
	{
            echo "<tfoot>\n";
		$hasFilter=$this->filter!==null && $this->filterPosition===self::FILTER_POS_FOOTER;
		$hasFooter=$this->getHasFooter();
		if($hasFilter || $hasFooter)
		{
			if($hasFooter)
			{
				echo "<tr>\n";
				foreach($this->columns as $column)
					$column->renderFooterCell();
				echo "</tr>\n";
			}
			if($hasFilter)
				$this->renderFilter();
		}

            $this->renderGridActions();
            echo "</tfoot>\n";
	}
}

?>
