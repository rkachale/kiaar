<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/bootstrap-table.min.css">
<div class="row">
    <div class="col-lg-12">
        <div class="portlet light bordered">
            <form class="" action="">
                <div class="form-body">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Crop Health Monitoring</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a class="sizebtn btn sbold orange" href="<?php echo base_url('cms/crop_health_monitoring/edit'); ?>">Add New
                                            <!-- <button id="sample_editable_1_new" class="sizebtn btn sbold orange"> Add New</button> -->
                                        </a>
                                    </span>
                                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a> </span>
                                </div>                                                         
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Farmer Name</label>
                                    <div class="farmer_name_wrap">
                                        <select class="select2 form-control custom-select" name="farmer_name" id="farmer_name" multiple style="width: 100%;" data-placeholder="-- Select Farmer Name --">
                                            <option value="">-- Select Farmer Name --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Year</label>
                                    <div class="year_wrap">
                                        <select class="select2 form-control custom-select" name="year" id="year" style="width: 100%;" data-placeholder="-- Select Year --">
                                            <option value="">-- Select Year Month --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Month</label>
                                    <div class="month_wrap">
                                        <select class="select2 form-control custom-select" name="month" id="month" multiple style="width: 100%;" data-placeholder="-- Select Month --">
                                            <option value="">-- Select Month --</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success" onclick="filterTable();">Filter</button>
                                <button type="button" class="btn btn-dark" onclick="clearTable();">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="portlet light bordered pt2 pb0">
            <div class="portlet-body">
                <div id="dataTableWrap">
                    <div class="table-responsive">
                        <table id="dataTableId"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/tableExport.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/js/select2.full.min.js"></script>

<style type="text/css">
.admin_menu .keep-open ul.dropdown-menu, .admin_menu .export ul.dropdown-menu {
    position: absolute;
    box-shadow: 5px 5px rgb(102 102 102 / 10%)!important;
    right: 0; 
    min-width: 175px;
    z-index: 9999;
    border: 1px solid #ccc!important;
    left: auto!important;
}
</style>
<script type="text/javascript">

    function get_farmername_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'cms/crop_health_monitoring/get_farmername_options_url/',
            data: {},
            success: function(response) {
                $("#farmer_name").removeAttr('disabled');
                $('.farmer_name_wrap').html('<select class="select2 form-control custom-select" data-placeholder="-- Select Farmer Name --" name="farmer_name" id="farmer_name" multiple style="width: 100%;">'+response+'</select>');
                $('#farmer_name').select2();
            }
        });
    }

    function get_year_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'cms/crop_health_monitoring/get_year_options_url/',
            data: {},
            success: function(response) {
                $("#year").removeAttr('disabled');
                $('.year_wrap').html('<select class="select2 form-control custom-select" data-placeholder="-- Select Year --" name="year" id="year" style="width: 100%;">'+response+'</select>');
                $('#year').select2();
            }
        });
    }

    // function get_month_options() {
    //     $.ajax({
    //         type: "POST",
    //         dataType: "json",
    //         url : base_url+'cms/crop_health_monitoring/get_month_options_url/',
    //         data: {},
    //         success: function(response) {
    //             $("#month").removeAttr('disabled');
    //             $('.month_wrap').html('<select class="select2 form-control custom-select" data-placeholder="-- Select Month --" name="month" id="month" multiple style="width: 100%;">'+response+'</select>');
    //             $('#month').select2();
    //         }
    //     });
    // }

    function filterTable() {
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        initTable();
    }

    function clearTable() {

        // $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');

        get_farmername_options();
        get_year_options();
        // get_month_options();

        setTimeout(function(){
            initTable();
            // hideLoader();
        }, 500);
    }

    function initTable() {
        $('#dataTableId').bootstrapTable({
            url: base_url+'cms/crop_health_monitoring/farmer_ajax_list',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        farmer_name             : $('#farmer_name').val(),
                                        year                    : $('#year').val(),
                                        month                   : $('#month').val(),
                                      }
                }
                return q;
            },
            cache: false,
            // height: 580,
            striped: true,
            toolbar: true,
            search: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            // detailView: true,
            // exportOptions: { ignoreColumn: [0] },
            detailView: false,
            // detailFormatter: detailFormatter,
            exportOptions: { ignoreColumn: ['action'], fileName: 'crop_health_monitoring' },
            showExport: true,
            exportDataType: 'all',
            minimumCountColumns: 2,
            showPaginationSwitch: true,
            pagination: true,
            sidePagination: 'server',
            idField: 'id',
            pageSize: 10,
            pageList: [10, 25, 50, 100, 200],
            showFooter: false,
            // responseHandler: responseHandler,
            clickToSelect: false,
            columns: [
                [
                    {
                        field: 'sr_no',
                        title: 'Sr No.',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'farmer_name',
                        title: 'Farmer Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'year_month',
                        title: 'Year and Month',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'status',
                        title: 'Status',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'action',
                        title: 'Action',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    }
                ]
            ]
        });
    }

    get_farmername_options();
    get_year_options();
    // get_month_options();
    initTable();



function change_status(id) {

        if(id != '')
        {
            var message = 'Do you really want to delete this?';
            var btn_text = 'Yes, Delete it!';

            swal({
                title: "Are you sure?",
                text: message,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: btn_text,
            }).then(function (result) {
                //if(result.value)
                if(result)
                {
                    window.location.href = base_url+'cms/crop_health_monitoring/delete/'+id;
                }
            }, function(dismiss) {});
        }
    }
</script>
