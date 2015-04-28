<div class="wrap">
    <div class="icon32" id="">
        <img src="<?php echo $this->_renderSlot("midi_logo") ?>" alt="WPJobBoard Logo" />
    </div>
    <h2 id="wpjb_title"><?php echo $this->_renderSlot("title"); ?></h2>

<?php foreach($this->_flash->getInfo() as $info): ?>
<div class="updated fade">
    <p><?php echo $info; ?></p>
</div>
<?php endforeach; ?>

<?php foreach($this->_flash->getError() as $error): ?>
<div class="error">
    <p><?php echo $error; ?></p>
</div>
<?php endforeach; ?>