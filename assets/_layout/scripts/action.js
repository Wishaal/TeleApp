//$.noConflict();
$(document).ready(function () {

    //conformation message for  delete buttons in overview
    $('a.icon.delete').click(function () {

        var confirmation = confirm('Are you sure you want to delete this item?');
        if (!confirmation) {
            return false;
        }
    });

    function submitForm() {
        //$(form).submit();
        alert('asdadasd');
        return false;
    }

    //alert('adsaad');
    $('.date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        maxDate: '0',
        minDate: '-3Y'
    });

    $('.date_6mnd').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:2030',
        maxDate: '0',
        minDate: '-6M'
    });

    $('.date2').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:2030',
        maxDate: '0',
        minDate: '-3Y'
    });

    $('.date3').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:2030',
        maxDate: '+7Y',
        minDate: '-3Y'
    });

    $('.date2_6mnd').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:2030',
        maxDate: '0',
        minDate: '-6M'
    });

    $('.birthdate').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '1900:' + new Date('Y')
    });

    //add & remove buttons voor werkgroep
    var btncount = $('a.add').length;
    $('a.add').live('click', function () {
        btncount++;
        var x = $(this).parent().find('select').html();
        var name = $(this).parent().find('select').attr('name');
        $('.add_box tbody').append('<tr><td><select id="sel_' + btncount + '" name="' + name + '">' + x + '<select><a href="#" class="icon add" title="Add"><img src="assets/_layout/images/icons/icon-docs.png" alt=""></a><a href="#" class="icon remove" title="Remove"><img src="assets/_layout/images/icons/icon-delete.png" alt=""></a></td></tr>');

        $('#sel_' + btncount).uniform();

        return false;
    });

    $('a.remove').live('click', function () {
        if ($('a.remove').length > 1)
            var x = $(this).parent().parent().remove();
        return false;
    });

    //add & remove buttons voor training
    $('#deelnemersbox tr').hide();
    $('#deelnemersbox tr:first').show();

    $('#deelnemersbox .btnadd').each(function () {
        $(this).click(function () {
            $('#deelnemersbox tr:hidden:first').show();
            return false;
        });
    });

    $('#deelnemersbox .btnremove').each(function () {
        $(this).click(function () {
            //$(this).parent().parent().hide();
            $(this).parent().children('div').children('div').children('select').each(function () {
                $(this).children('option:first').attr('selected', 'selected');
            });
            var v = $(this).parent().children('div').children('div').children('select').children('option:first').html();
            $(this).parent().children('div').children('div').children('span').html(v);
            return false;
        });
    });

});