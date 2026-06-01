<div id="tab1" class="table-list tab tab1">
    <div class="brand_title">
        <div id="myDiv" class="pdf_export">
            <?php echo '<a target="_blank" href="' . Yii::app()->createUrl('//mobile/'.$carsPdf, array('make' => $makeName, 'rangecode' => $rangecode, 'rangename' => $modelName)) . '&page='.$page.'"><img src="'.Yii::app()->params['mobile_url'].'images/pdf.png"
            style="width:28px; height:28px;" alt="[pdf]"></a>'; ?>
        </div>
        <div id="titleFieldFromXml"><?php echo $makeName; ?></span>
    </div>
    <p class="desktop-display">Please click on Model description to expand vehicle data.</p>
    <p class="mobile-landscape-display">Please <strong>select the variant</strong> to see the corresponding tax information.</p>
    <p class="mobile-display">Please rotate your device to see all details.</p>
</div>
<div class="table-wrapper">
    <table class="items">
        <thead>
            <tr>
                <th scope="col">Model</th>
                <th scope="col">Variant</th>
                <th scope="col" class="drs-text">Drs</th>
                <th scope="col" class="body">Body</th>
                <th scope="col" class="text-right">Fuel</th>
                <th scope="col" class="text-right">Transmission</th>
                <th scope="col" class="gvw-text" style="display: none;">GVWkg</td>
                <th scope="col">CC</th>
                <th scope="col" class="bhp-text">Bhp</th>
                <th scope="col">Co2</th>
                <th scope="col">Retail €</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach( $variantData as $variant ){ ?>
                    <tr>
                        <td data-label="Model">
                            <?php echo $variant[ 'model' ]; ?>
                        </td>
                        <td data-label="Variant">
                            <a href="#myModal" data-toggle="modal" data-target="#myModal"
                            class="ui-link"><?php echo $variant[ 'variant' ]; ?></a>
                        </td>
                        <td data-label="Drs" class="drs-text"><?php echo $variant[ 'doors' ]; ?></td>
                        <td data-label="Body" class="body"><?php echo $variant[ 'body' ]; ?></td>
                        <td data-label="Fuel" class="text-right"><?php echo $variant[ 'fuel' ]; ?></td>
                        <td data-label="Transmission" class="text-right"><?php echo $variant[ 'transmission' ]; ?></td>
                        <td data-label="GVWkg" class="gvw-text" style="display: none;"><?php echo $variant[ 'tax' ]; ?></td>
                        <td data-label="CC"><?php echo $variant[ 'cc' ]; ?></td>
                        <td data-label="Bhp" class="bhp-text"><?php echo $variant[ 'bhp' ]; ?></td>
                        <td data-label="Co2"><?php echo $variant[ 'co2' ]; ?></td>
                        <td data-label="Retail €"><?php echo $variant[ 'retail' ]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<div id="" class="table-list tab tab2">
    <div class="brand_title">
        <div id="myDiv" class="pdf_export">
            <?php echo '<a class="ui-link" target="_blank" href="' . Yii::app()->createUrl('//mobile/'.$carsPdf, array('make' => $makeName, 'rangecode' => $rangecode, 'rangename' => $modelName)) . '&page='.$page.'"><img src="'.Yii::app()->params['mobile_url'].'images/pdf.png"
            style="width:28px; height:28px;" alt="[pdf]"></a>'; ?>
        </div>
        <div id="titleFieldFromXml"><?php echo $makeName; ?><!--span id="effectiveFieldFromXml">(Effective
        28/3/19)</span--></div>
        <p>Please click on the variant to see the corresponding tax information.</p>
    </div>
    <div class="table-wrapper">
        <table class="items">
            <thead>
                <tr>
                    <th scope="col">Model</th>
                    <th scope="col">Variant</th>
                    <th scope="col" class="drs-text">Drs</th>
                    <th scope="col" class="body">Body</th>
                    <th scope="col" class="text-right">Fuel</th>
                    <th scope="col" class="text-right">Transmission</th>
                    <th scope="col" class="gvw-text" style="display: none;">GVWkg</td>
                    <th scope="col">CC</th>
                    <th scope="col" class="bhp-text">Bhp</th>
                    <th scope="col">Co2</th>
                    <th scope="col">Retail €</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $variantData as $variant ){ ?>
                    <tr>
                        <td data-label="Model">
                            <?php echo $variant[ 'model' ]; ?>
                        </td>
                        <td data-label="Variant">
                            <a href="#myModal" data-toggle="modal" data-target="#myModal"
                            class="ui-link"><?php echo $variant[ 'variant' ]; ?></a>
                        </td>
                        <td data-label="Drs" class="drs-text"><?php echo $variant[ 'doors' ]; ?></td>
                        <td data-label="Body" class="body"><?php echo $variant[ 'body' ]; ?></td>
                        <td data-label="Fuel" class="text-right"><?php echo $variant[ 'fuel' ]; ?></td>
                        <td data-label="Transmission" class="text-right"><?php echo $variant[ 'transmission' ]; ?></td>
                        <td data-label="GVWkg" class="gvw-text" style="display: none;"><?php echo $variant[ 'tax' ]; ?></td>
                        <td data-label="CC"><?php echo $variant[ 'cc' ]; ?></td>
                        <td data-label="Bhp" class="bhp-text"><?php echo $variant[ 'bhp' ]; ?></td>
                        <td data-label="Co2"><?php echo $variant[ 'co2' ]; ?></td>
                        <td data-label="Retail €"><?php echo $variant[ 'retail' ]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>