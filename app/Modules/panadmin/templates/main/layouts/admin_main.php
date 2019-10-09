<?php
use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= MODULE_ADMIN_TITLE; ?></title>
    <?php
    Assets::css([
        Url::templateModulePath() . 'css/select2.min.css',
        Url::templateModulePath() . 'css/bootstrap.min.css',
        Url::templateModulePath() . 'css/metisMenu.min.css',
        Url::templateModulePath() . 'css/sb-admin-2.css',
        Url::templateModulePath() . 'css/minimal.css',
        Url::templateModulePath() . 'css/font-awesome.min.css',
        Url::templateModulePath() . 'css/bootstrap-switch.min.css',
        Url::templateModulePath() . 'css/bootstrap-datetimepicker.min.css',
        Url::templateModulePath() . 'css/bootstrap-timepicker.min.css',
        Url::templateModulePath() . 'css/daterangepicker.min.css',
        Url::templateModulePath() . 'css/themify-icons.css',
        Url::getPath('Components') . 'fancybox/source/jquery.fancybox.css?v=2.1.5',
        Url::templateModulePath() . 'css/custom.css',

    ]);
    $hooks->run("css");
    ?>
</head>
<body onload="startTime()">
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <?php
        include("inc/main_header.php");
        include("inc/main_menu.php");
        ?>
    </nav>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?= \Helpers\Session::getFlash(); ?>
                    <?php eval($content); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="baseUrl" value="<?= Url::to(Url::getModuleController()) ?>"/>
<?php
Assets::js([
    Url::templateModulePath() . 'js/jquery.min.js',
    Url::templateModulePath() . 'js/bootstrap.min.js',
    Url::templateModulePath() . 'js/select2.full.min.js',
    Url::templateModulePath() . 'js/metisMenu.min.js',
    Url::templateModulePath() . 'js/sb-admin-2.js',
    Url::templateModulePath() . 'js/bootstrap-switch.min.js',
    Url::templateModulePath() . 'js/bootstrap-confirmation.min.js',
    Url::templateModulePath() . 'js/moment.js',
    Url::templateModulePath() . 'js/icheck.min.js',
    Url::templateModulePath() . 'js/bootstrap-datetimepicker.min.js',
    Url::templateModulePath() . 'js/bootstrap-timepicker.min.js',
    Url::templateModulePath() . 'js/daterangepicker.min.js',
    Url::getPath('Components') . 'ckeditor/ckeditor.js',
    Url::getPath('Components') . 'fancybox/lib/jquery.mousewheel-3.0.6.pack.js',
    Url::getPath('Components') . 'fancybox/source/jquery.fancybox.pack.js?v=2.1.5',
    Url::templateModulePath() . 'js/script_coders.js',
    Url::templateModulePath() . 'js/locationpicker.jquery.js',
    Url::templateModulePath() . 'js/custom.js',
]);
$hooks->run('js');
?>

<?php
if(isset($_GET['from']) && isset($_GET['to'])){
    $startDate = $_GET['from'];
    $endDate = $_GET['to'];
}else{
    $startDate = date("d-m-Y");
    $endDate = date("d-m-Y");
}
?>
<script>
    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD'
        });
    });
    $(document).ready(function () {
        $('#daterange').daterangepicker(
            {
                locale   : {
                    format: 'DD-MM-YYYY'
                },
                startDate: "<?=$startDate?>",
                endDate  : "<?=$endDate?>"
            },
            function (start, end, label) {
                $('#from_date').val(start.format('DD-MM-YYYY'));
                $('#to_date').val(end.format('DD-MM-YYYY'));
                $('#partnerstats').submit();
            }
        )
    });
</script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyDXezpm4RBGAPdcOOQjhYcB7ywop9bCxds'></script>

<script>
    $(function () {
        $(".select2").select2();

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        /*$("#phone").mask("99/99/9999");*/
    });
    //CK editor
    var dd = 1;
    $(".editor").each(function () {

        $(this).attr("id", "editor" + dd);

        CKEDITOR.replace('editor' + dd, {
            filebrowserBrowseUrl : '<?=Url::getPath('Components')?>aaaFinder/elfinder.html', // eg. 'includes/elFinder/elfinder.html',
            filebrowserImageBrowseUrl: '<?=Url::getPath('Components')?>aaaFinder/elfinder.html',
            filebrowserFlashBrowseUrl: '<?=Url::getPath('Components')?>aaaFinder/elfinder.html',
            extraPlugins: 'youtube',
            language: 'tr'
        });
        dd = dd + 1;
    });

    $(document).ready(function() {
        $(".fancybox").fancybox();
    });

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time_clock').innerHTML =
            h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
    $(function(){
        //Appending HTML5 Audio Tag in HTML Body
        $('<audio id="chatAudio"><source src="<?=Url::templateModulePath()?>sound/notify.ogg" type="audio/ogg"></audio>').appendTo('body');
    });

    <?php
    if(\Helpers\Url::getFullUrl()=='admin/main' OR \Helpers\Url::getFullUrl()=='admin/main/index'):
    ?>
    function getNotify() {
        $.ajax({
            type: 'POST',
            url:'/admin/Main/notify',
            data: {
                notify: 'notify'
            },
            dataType: 'json',
            encode: true
        }).done(function(data) {
            if (data.success) {
                if(data.sound){
                    $('#chatAudio')[0].play();
                }

                if(data.count_view){
                    $('#count_new_order').html(data.count_message);
                    $('.uk-badge').removeClass('uk-badge-mutedd');
                }else{
                    $('.uk-badge').addClass('uk-badge-mutedd');
                }
            }

        });
    }
    setInterval('getNotify()', 4*1000);
    <?php
    endif;
    ?>

</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker3').datetimepicker({
            format: 'HH:mm',
        });
        $('#datetimepicker4').datetimepicker({
            format: 'HH:mm',
        });
    });
</script>
</body>
</html>
