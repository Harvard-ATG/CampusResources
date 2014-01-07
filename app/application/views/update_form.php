<html>
<head>
    <title>Update Links</title>
</head>
<body>

<?php echo $error;?>
<br>
Download current Link Database as CSV file  (Edit with Excel):
<br>
<?php echo form_open('update/downloadLinks'); ?>
<?php echo form_submit("download", "Download Links"); ?>
<?php echo form_close(); ?>
<br>
<hr>
<br>
<?php echo form_open_multipart('update/do_upload');?>
Update Links by Uploading new CSV Here:
<?php echo form_upload(array('name' => 'userfile', 'size' => '20'));  ?>
<br><br>
<?php echo form_submit('submit', 'Upload Links'); ?>
<?php echo form_close(); ?>

</body>

</html>
