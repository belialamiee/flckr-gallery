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
                                    <input type="text" class="form-control" id="searchTerm" name="searchTerm" value="<?= $searchTerm?>">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-default">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Thumb</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($searchResults){
                            foreach($searchResults as $result){?>
                            <tr>
                                <td class="max-width:100px;"><a href="view/<?= $result['id']; ?>"><?= $result['title']; ?></a></td>
                                <td><img src="https://farm<?=$result['farm'];?>.staticflickr.com/<?=$result['server'];?>/<?=$result['id'];?>_<?=$result['secret'];?>_t.jpg">"></td>
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
    <script type="text/javascript">
        //on click of the elements set it as the search term and submit the form.
        $('.searchNow').on('click', function (e) {
            var element = e.target;
            $("#searchTerm").val(element.id);
            $("#searchForm").submit();
        });
        //create a modal show function in here.
        //on click have the contents of the image and the contents of the title updated
        //then show the modal.

    </script>
@endsection
