<?php
Yii::import('zii.widgets.grid.CCheckBoxColumn');

class QCheckBoxColumn extends CCheckBoxColumn {
    public $renderContent='"true"';
    public $headerCheckBoxHtmlOptions=array();
    
	public function init()
	{
		if(isset($this->checkBoxHtmlOptions['name']))
			$name=$this->checkBoxHtmlOptions['name'];
		else
		{
			$name=$this->id;
			if(substr($name,-2)!=='[]')
				$name.='[]';
			$this->checkBoxHtmlOptions['name']=$name;
		}
		$name=strtr($name,array('['=>"\\[",']'=>"\\]"));

		if($this->selectableRows===null)
		{
			if(isset($this->checkBoxHtmlOptions['class']))
				$this->checkBoxHtmlOptions['class'].=' select-on-check';
			else
				$this->checkBoxHtmlOptions['class']='select-on-check';
			return;
		}

		$cball=$cbcode='';
		if($this->selectableRows==0)
		{
			//.. read only
			$cbcode="return false;";
		}
		elseif($this->selectableRows==1)
		{
			//.. only one can be checked, uncheck all other
			$cbcode="$(\"input:not(#\"+$(this).attr('id')+\")[name='$name']\").attr('checked',false);";
		}
		else
		{
			//.. process check/uncheck all
			$cball=<<<CBALL
$('#{$this->id}_all').live('click',function() {
	var checked=this.checked;
        var sender=this;
	$(this).closest('table.items').children('tbody').children('tr').children('td.checkbox-column').children('input[type="checkbox"]').each(function() {
            this.checked=checked;
            $(this).poke_checkbox($(sender));
        });
});
CBALL;
			//$cbcode="$('#{$this->id}_all').attr('checked', $(\"input[name='$name']\").length==$(\"input[name='$name']:checked\").length);";
		}

		$js=$cball;
		$js.=<<<EOD
$("input[name='$name']").live('click', function() {
        $(this).poke_checkbox($(this));
});
EOD;
    if(!Yii::app()->getClientScript()->isScriptRegistered('QCheckBoxColumn')) {
$qcbcjs=<<<QCBC
$.fn.poke_checkbox = function(sender) {
var currentGridTable=$(this).closest('table.items');


//aktualizuj checkAll
//if(sender.closest('table.items').children('thead').children('tr').children('th.checkbox-column:first').children('input[type="checkbox"]').get(0)!=$(this).closest('table.items').children('thead').children('tr').children('th').children('input[type="checkbox"]').get(0)) {
    currentGridTable.children('thead').children('tr').children('th.checkbox-column:first').children('input[type="checkbox"]').attr('checked',
        currentGridTable.children('tbody').children('tr').children('td.checkbox-column').children('input[type="checkbox"]:checked').length==
        currentGridTable.children('tbody').children('tr').children('td.checkbox-column').children('input[type="checkbox"]').length
    );
//}
var checkAllChecked=currentGridTable.children('thead').children('tr').children('th.checkbox-column:first').children('input[type="checkbox"]').attr('checked');
//zaznacz subgrid
var subGridElement=$(this).closest('tr').children('td').children('div.grid-view').children('table.items');
if(sender.closest('table.items').get(0)!=subGridElement.get(0)) {
    subGridElement.children('thead').children('tr').children('th.checkbox-column:first').children('input[type="checkbox"]').attr('checked', $(this).attr('checked'));
    subGridElement.children('tbody').children('tr').children('td.checkbox-column').children('input[type="checkbox"]').attr('checked', $(this).attr('checked'));
    subGridElement.children('tbody').children('tr').children('td.checkbox-column').children('input[type="checkbox"]').poke_checkbox($(this));
}

//aktualizuj stan checkboxa rodzica
var parentCB=$(this).closest('table.items').closest('tr').children('td.checkbox-column:first').children('input[type="checkbox"]:first');
if(parentCB.attr('checked')!=checkAllChecked) {
    parentCB.attr('checked', checkAllChecked);
    parentCB.poke_checkbox($(this));
}
};
QCBC;
Yii::app()->getClientScript()->registerScript('QCheckBoxColumn', $qcbcjs);
    }
    
    Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id,$js);
    
    
    }    
    
    protected function renderDataCellContent($row,$data) {        
        if($this->evaluateExpression($this->renderContent,array('data'=>$data,'row'=>$row))) {
            parent::renderDataCellContent($row, $data);
        }
    }
       
    protected function renderHeaderCellContent()
    {
                if($this->selectableRows===null && $this->grid->selectableRows>1) {
                    if(isset($this->headerCheckBoxHtmlOptions['class']))
                        $this->headerCheckBoxHtmlOptions['class'].=' select-on-check-all';
                    else
			$this->headerCheckBoxHtmlOptions['class']='select-on-check';
                    echo CHtml::checkBox($this->id.'_all',false, $this->headerCheckBoxHtmlOptions);
                }
                else if($this->selectableRows>1)
                        echo CHtml::checkBox($this->id.'_all',false, $this->headerCheckBoxHtmlOptions);
                else
                        parent::renderHeaderCellContent();
    }
}
?>
