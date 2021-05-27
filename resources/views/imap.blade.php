<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IMAP') }}
        </h2>
    </x-slot>
    <style>
    body {
        background: #eee
    }

    .icons i {
        color: #b5b3b3;
        border: 1px solid #b5b3b3;
        padding: 6px;
        margin-left: 4px;
        border-radius: 5px;
        cursor: pointer
    }

    .activity-done {
        font-weight: 600
    }

    .list-group li {
        margin-bottom: 12px
    }

    .list-group-item {}

    .list li {
        list-style: none;
        padding: 10px;
        border: 1px solid #e3dada;
        margin-top: 12px;
        border-radius: 5px;
        background: #fff
    }

    .checkicon {
        color: green;
        font-size: 19px
    }

    .date-time {
        font-size: 12px
    }

    .profile-image img {
        margin-left: 3px
    }

    li {
        cursor: pointer;
    }

    #loading {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('{{ url("loading.gif") }}') 50% 50% no-repeat rgb(255, 255, 255);
    }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div id="loading"></div>
    <div class="container" style="margin-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('IMAP') }}
                    </div>
                    <div class="card-body" style="margin-bottom: 20px;">
                        <div class="col-md-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mt-3">
                                            <ul class="list list-inline">
                                                @foreach ($mids as $key => $mid)
                                                <li class="d-flex justify-content-between mids" data-id="{{ $mid }}" data-counter="{{ $key }}">
                                                    <div class="d-flex flex-row align-items-center"><i class="fa fa-check-circle checkicon"></i>
                                                        <div class="ml-2">
                                                            <h6 class="mb-0"><b>Subject: </b>{{ $subjects[$key] }}</h6>
                                                            <div><b>AttachMents: </b>{{ $attachments[$key] }}</div>
                                                            <div class="adding_html" id="und{{ $key }}"></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                            {{-- <ul class="list list-inline">
                                                <li class="d-flex justify-content-between mids" data-id="c9c1c589023ee7ee4a782984e87a92f888e0cfa8-20113407-110703341@google.com" data-counter="1">
                                                   <div class="d-flex flex-row align-items-center">
                                                      <div class="ml-2">
                                                         <h6 class="mb-0"><b>Subject: </b>Bhargav, finish setting up your new Google Account</h6>
                                                         <div><b>AttachMents: </b>0</div>
                                                         <div class="adding_html" id="und1"></div>
                                                      </div>
                                                   </div>
                                                </li>
                                                <li class="d-flex justify-content-between mids" data-id="CAEXeNNWBcH6sW_L_f9ysT24h1vG-ZHmKbSJNeXtfNYYsrzgY+w@mail.gmail.com" data-counter="2">
                                                   <div class="d-flex flex-row align-items-center">
                                                      <div class="ml-2">
                                                         <h6 class="mb-0"><b>Subject: </b>Hello Admin@Bhargavaa</h6>
                                                         <div><b>AttachMents: </b>0</div>
                                                         <div class="adding_html" id="und2"></div>
                                                      </div>
                                                   </div>
                                                </li>
                                                <li class="d-flex justify-content-between mids" data-id="CAEXeNNX0Jxh5wmw-nT1BYovU=3Q8aEBqi2Yz-3VgSDyovkpKPQ@mail.gmail.com" data-counter="3">
                                                   <div class="d-flex flex-row align-items-center">
                                                      <div class="ml-2">
                                                         <h6 class="mb-0"><b>Subject: </b>Hello Admin@Bhargavaa</h6>
                                                         <div><b>AttachMents: </b>1</div>
                                                         <div class="adding_html" id="und3">

                                                         </div>
                                                      </div>
                                                   </div>
                                                </li>
                                            </ul> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function(){
        $('#loading').hide();
        $('.mids').click(function() {
            $('#loading').show();
            htm = $(this).find('.adding_html').html();
            if(htm != '') {
                $(this).find('.adding_html').html('');
                $('#loading').hide();
                return false;
            } else {
                id = $(this).data('id');
                counter = $(this).attr('data-counter');
                $.ajax({
                    url: '{{ route('pert_mail') }}',
                    data: {id: id},
                    type: 'GET',
                    success:function(resp) {
                        $('#und'+counter).html(resp);
                        $('#loading').hide();
                    }
                });
            }
        });
    });
</script>
