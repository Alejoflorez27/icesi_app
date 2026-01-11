<?php CtrUsuario::logout();?>

<script>
    window.location = "<?= constant('APP_URL') ?>";
    localStorage.removeItem('<?= constant('APP_TOKEN_NAME') ?>');
</script>
