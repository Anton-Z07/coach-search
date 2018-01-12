var l = console.log.bind(console);
$(function() {
    if ($.fn.dataTable) {
    	$.extend( $.fn.dataTable.defaults, {
            dom: '<"datatable-header"><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
    	        "url": "/theme/assets/Russian.json"
    	    },
            aaSorting: [[1, 'desc']]
        });
        $('.daterange-basic').daterangepicker({
            autoApply: true,
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-default',
            separator: ' - ',
            ranges: {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Последние 7 дней': [moment().subtract('days', 6), moment()],
                'Последние 30 дней': [moment().subtract('days', 29), moment()],
                'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                'Прошедший месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            locale: {
                format: 'DD.MM.YYYY',
                applyLabel: 'Вперед',
                cancelLabel: 'Отмена',
                startLabel: 'Начальная дата',
                endLabel: 'Конечная дата',
                customRangeLabel: 'Выбрать дату',
                daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                firstDay: 1
            }
        });
    }
    $('.datepicker').datepicker({
        language: "ru",
        autoclose: true,
        format: "dd.mm.yyyy",
    });
    if ($('.datepicker.start-today').size())
    	$('.datepicker.start-today').datepicker('setStartDate', moment().format('DD.MM.YYYY'));

    $('.date').mask('99.99.9999');
    $('.mask').each(function(){
        $(this).mask( $(this).attr('mask') );
    });
    initAjaxReload();
    initBtnConfirm();
    $('ul.navigation-main li').each(function(){
        var url = $(this).find('a').attr('href').split('?')[0];
        if ($(this).find('a').size() && url.toUpperCase() == window.location.pathname.toUpperCase())
        {
            $(this).addClass('active');
            if ($(this).closest('ul').hasClass('hidden-ul'))
            {
                $(this).closest('ul').show();
                $(this).closest('ul').closest('li').addClass('active');
            }
        }
    });
    $('.switchery:not(.pending)').each(function(){
        new Switchery(this);
    });
});

function getWordForm(n, w1, w2, w3)
{
    if (typeof n == 'number') n = n.toString();
    var last_digit = n[n.length-1];
    if (n.length>=2)
    {
        var last_two_digits = n[n.length-2] + n[n.length-1];
        if ($.inArray(last_two_digits, ['11', '12', '13', '14', '15', '16', '17', '18', '19'])!=-1) return w3;
    }
    if ($.inArray(last_digit, ['0', '5', '6', '7', '8', '9'])!=-1) return w3;
    if (last_digit == '1') return w1;
    if ($.inArray(last_digit, ['2', '3', '4'])!=-1) return w2;
}

function closeDialog()
{
    $('#shadow').hide();
    $('.modal-dialog-open').hide();
    $('.modal-dialog-open').removeClass('modal-dialog-open');
    $('body').removeClass('modal-open');
}

function showDialog(id)
{
    $('body').addClass('modal-open');
    if (!$('#shadow').size()) {
        $('body').append('<div id="shadow"></div>');
        $('#shadow').click(function() {
            if ($(this).hasClass('clickable'))
                closeDialog();
        });
    }
    $('#shadow').show();
    $('#shadow').addClass('clickable');
    $('#'+id).addClass('modal-dialog-open');
    $('#'+id).show();
}

function jsonDialog(dialog_id, url, data)
{
    data = data | {};
    l(data);
    $.getJSON(url, data, function(data) {
        for (var holder in data) {
            $('#'+dialog_id).find('[data-bind-text='+holder+']').text( data[holder] );
            $('#'+dialog_id).find('[data-bind-val='+holder+']').val( data[holder] );
        }
        showDialog(dialog_id);
    });
}

function initAjaxReload()
{
    $('.btn-ajax-reload').click(function(){
        var replaceable = eval($(this).attr('data-replaceable'));
        $.get($(this).attr('data-url'), function(data){
            replaceable.before(data);
            replaceable.remove();
            initAjaxReload();
        });
    });
}

function initBtnConfirm()
{
    $('.btn-confirm').click(function(){
        var text = "Точно выполнить это действие?";
        if ($(this).attr('data-confirm-text')) text = $(this).attr('data-confirm-text');
        return confirm(text);
    });
}

function OnContTypeChange(radio) 
{
    var name = $(radio).attr('name').split('[')[0] + '_type';
    var id = name + '_' + $(radio).val();
    $('.'+name).hide();
    $('#'+id).find('input').prop('disabled', false);
    $('#'+id).show();
    $('.'+name).not('#'+id).find('input').prop('disabled', true);
}

function OnContChange(type, select) 
{
    if ($(select).val() == '0') {
        $('.'+type).find('input').prop('disabled', false);
        $('.'+type).find('input[type="text"]').val('');
    }
    else {
        $('.'+type).find('input').prop('disabled', true);
        $.getJSON('/common/GetContractorData', { id: $(select).val() }, function(data){
            if (($(select).val() != data['id']))
                return;
            $('.'+type).find('input').each(function(){
                var inp = $(this);
                var type = inp.attr('name').split('[')[1].replace(']','');
                if (data[type]) {
                    if(this.type=="radio") {
                        if(inp.val() == data[type]) {
                            inp.prop("checked", true);
                            inp.change();
                        }
                    }
                    else
                        inp.val(data[type]);
                }
            });
            $('.'+type).find('input').prop('disabled', true);
        })
    }
}