<style>
.verNr, .success, .error {font-weight: bold}
.section {margin-top: 10px; margin-bottom: 10px}
.success {color: green}
.error {color: red}
.subsection {margin-left: 10px}
</style>
<h2>QUpgrade - moduł aktualizacji systemu</h2>
<h3>Informacje o systemie</h3>
<div class="section">
	<?php $version=$this->module->getVersion(); ?>
	<div>Wersja aplikacji: <span class="verNr"><?php echo $version['app_version']; ?></span></div>
	<div>Wersja bazy danych: <span class="verNr"><?php echo $version['db_version']; ?></span></div>
</div>
<?php if($upgradeSystem): ?>
	<div class="section">
		<div>Aktualizacja do wersji: <span class="verNr"><?php echo $upgradeSystem->version; ?></span></div>
		<div>Dane połączenia z bazą danych: <span class="verNr"><?php echo $upgradeSystem->db->connectionString; ?></span></div>
		<div>Sprawdzam warunki aktualizacji: </div>
		<div class="subsection">
			<?php $preCond=$upgradeSystem->checkPreconditions(); //var_dump($preCond);die;?>
			<?php if(empty($preCond)): ?>
				<div class="success">Brak warunków</div>
			<?php else: ?>
				<?php foreach($preCond as $name=>$pc): ?>
					<?php echo CHtml::tag('div', array('class'=>$pc===true?'success':'error'), $name.' - '.($pc===true?'OK':implode('<br/>', $pc['errors']))); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div>Etapy aktualizacji: </div>
		<div class="subsection">
			<?php $stages=$upgradeSystem->stages(); //var_dump($preCond);die;?>
			<?php if(empty($stages)): ?>
				<div class="error">Brak zdefiniowanych etapów.</div>
			<?php else: ?>
				<?php foreach($stages as $name): ?>
					<div><?php echo $name; ?></div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php echo CHtml::form().CHtml::hiddenField('run', 1).CHtml::submitButton('Aktualizuj').CHtml::endForm(); ?>
	</div>
<?php else: ?>
	<div class="section">
		<div>Dostępne skrypty aktualizacyjne:</div>
		<?php $upgrades=$this->module->getUpgrades(); ?>
		<?php if($upgrades===false): ?>
			<div class="error">Nie zdefiniowano ścieżki dostępu do plików aktualizacyjnych systemu w ustawieniach aplikacji (modules->qupgrade->upgradeFilesPath).</div>
		<?php else: ?>
			<?php foreach($upgrades as $upgrade): ?>
				<div class="subsection">
					<div><?php echo CHtml::link('Wersja '.$upgrade, array('', 'version'=>$upgrade)); ?></div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php endif;?>