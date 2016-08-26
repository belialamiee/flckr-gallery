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
                                           value="<?= $searchTerm?>">
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
                            <?php
                            if($searchData){
                            foreach($searchData['searchResults'] as $result){?>
                            <tr>
                                <td style="max-width:100px;"><?= $result['title']; ?>
                                </td>
                                <td class="img"><img class="img"
                                         src="https://farm<?=$result['farm'];?>.staticflickr.com/<?=$result['server'];?>/<?=$result['id'];?>_<?=$result['secret'];?>_t.jpg">
                                </td>
                            </tr>
                            <?php }
                            }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Previous Searches <span style="color:lightgray"> - Displays only the latest 5 events;</span>
                    </div>
                    <div class="panel-body">
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
                            <li id="<?= $search->searchTerm;?>" class="searchNow"><?= $search->searchTerm;?></li>
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

    <script type="text/javascript" src=""></script>
    <script type="text/javascript">
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
                }?>
               <?php if($searchData['pageNumber']){
                echo "pageNumber = ". $searchData['pageNumber'].";";
                }?>

            var dataTable = $('#resultsTable').DataTable({
            dom: '<"datatable-header"><""t><"datatable-footer"p>',

        });


        $('.img').on('click', function (e) {
            var src = e.target.src;
            //remove the -t option which shows a thumb instead
            src = src.slice(0,-6)+'.jpg';
            var modalDisplay = $('#imageModal');

            var img = '<img src="' + src + '" class="img-responsive"/>';
            modalDisplay.modal();
            modalDisplay.on('shown.bs.modal', function(){
                $('#imageModal .modal-body').html(img);
            });
            modalDisplay.on('hidden.bs.modal', function(){
                $('#imageModal .modal-body').html('');
            });

        });


    </script>
@endsection
