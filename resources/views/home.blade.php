@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Search Engine</div>
                    <div class="panel-body">
                        <form id="searchForm" class="form-horizontal" role="form" method="POST"
                              action="{{ url('/search') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Search</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="searchTerm" name="searchTerm"
                                           value="{{ $searchData['searchTerm'] }}">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-default">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-responsive table-hover" id="resultsTable">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Thumb</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <br/>
                        <a class="btn btn-default previous">
                            Previous
                        </a>
                        <a class="btn btn-default next">
                            Next
                        </a>


                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Previous Searches <span style="color:lightgray"> - Displays only the latest 5 searches</span>
                    </div>
                    <div class="panel-body" style="cursor:pointer;">
                        <ul>
                            <?php

                            if(count($searches)){
                            $counter = 0;
                            foreach ($searches as $search) {
                            $counter++;
                            if ($counter > 5) {
                                break;
                            }
                            ?>
                            <li style="list-style: none;" id="<?= $search->searchTerm;?>" class="searchNow"><?= $search->searchTerm;?></li>
                            <?php
                            }
                            }else{
                            ?>
                            <p>There have been no searches from this user.</p>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src=""></script>
    <script type="text/javascript">

        var tableData = "";
        <?php if($searchData){
                echo "tableData = ". json_encode($searchData).";";
                }?>
         //on click of the elements set it as the search term and submit the form.
        $('.searchNow').on('click', function (e) {
            var element = e.target;
            $("#searchTerm").val(element.id);
            $("#searchForm").submit();
        });
        var pages = "";
        var pageNumber = "";
                <?php if($searchData['pages']){
                echo "pages = ". $searchData['pages'].";";
                }
                if($searchData['pageNumber']){
                echo "pageNumber = ". $searchData['pageNumber'].";";
                }?>

                            var dataTable = $('#resultsTable').DataTable({
            dom: '<"datatable-header"><""t><"datatable-footer">',
            data: tableData.searchResults,
            columns: [

                {
                    "data": "title",
                    render: function (data, type, full, meta) {
                        return data;
                    }
                },
                {
                    "data": "id",
                    render: function (data, type, full, meta) {
                        return '<img class="img" src="https://farm' + full.farm + '.staticflickr.com/' + full.server + '/' + full.id + '_' + full.secret + '_t.jpg">';
                    }
                }
            ]
        });
        $('.img').on('click', function (e) {
            var src = e.target.src;
            //remove the -t option which shows a thumb instead
            src = src.slice(0, -6) + '.jpg';
            var modalDisplay = $('#imageModal');
            var img = '<img src="' + src + '" class="img-responsive"/>';
            modalDisplay.modal();
            modalDisplay.on('shown.bs.modal', function () {
                $('#imageModal .modal-body').html(img);
            });
            modalDisplay.on('hidden.bs.modal', function () {
                $('#imageModal .modal-body').html('');
            });
        });

        $('.next').on('click', function () {
            pageNumber++;
            var url = '/search-ajax/searchTerm/' + $("#searchTerm").val()+'/pageNumber/'+pageNumber;
            $.get( url, function(data) {
            tableData = data;
            });

            dataTable.ajax.reload();

        });
        $('.previous').on('click', function () {
            pageNumber--;
            //make ajax
            console.log('call previous data');
        });
    </script>
@endsection
