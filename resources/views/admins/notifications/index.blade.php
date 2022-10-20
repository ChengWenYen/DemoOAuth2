@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>LINE Notification</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-inline-flex align-items-center">
                                <h3 class="card-title">Notifications</h3>
                            </div>
                            <div class="card-tools">
                                <button class="btn btn-primary" onclick="openModal()">
                                    <i class="fas fa-plus"></i>
                                    CREATE
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No.</th>
                                        <th class="text-capitalize">Message</th>
                                        <th class="text-capitalize">Notify User Count</th>
                                        <th class="text-capitalize">Created</th>
                                        <th class="text-capitalize text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($notifications->total() == 0)
                                        <tr>
                                            <td colspan="5" class="text-center">No data.</td>
                                        </tr>
                                    @else
                                        @foreach ($notifications as $index => $notification)
                                            @foreach ($notification->recipients as $recipient)
                                                <input type="text" name="notify_{{ $notification->id }}_recipients[]" value="{{ $recipient->name() }}" hidden>    
                                            @endforeach
                                            <tr>
                                                <td>
                                                    {{ ($notifications->currentPage()-1) * $notifications->perPage() + ($index+1) }}
                                                </td>
                                                <td class="jsNotify_{{ $notification->id }}_message">
                                                    {{ $notification->message }}
                                                </td>
                                                <td>
                                                    {{ $notification->recipients()->count() }}
                                                </td>
                                                <td>
                                                    {{ $notification->created_at }}
                                                </td>
                                                <td class="text-right">
                                                    <button class="btn btn-info text-uppercase btn-sm" style="letter-spacing: 0.1em;" onclick="openShowModal('{{ $notification->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $notifications->links('layouts.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="create-modal-lg">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-tilte">CREATE LINE Notify</h4>
                    <button type="button" class="close" onclick="closeModal('create-modal-lg')" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-hidden">
                    <div class="card card-primary">
                        <form id="create-form" action="{{ route('admin.notify.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="message" class="h4">Message text</label>
                                    <textarea id="message" class="form-control" name="message" style="height: 250px"
                                        placeholder="message"
                                        autocomplete="off"></textarea>
                                </div>
                                <div id="msgErr" class="invalid-feedback mb-3">必填</div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger text-uppercase" style="letter-spacing: 0.1em;" data-dismiss="modal">Cancel</button>
                                    <button id="publishBtn" type="button" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" onclick="return doSubmit();">Publish</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="show-modal-lg">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-tilte">VIEW LINE Notify</h4>
                    <button type="button" class="close" onclick="closeModal('show-modal-lg')" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-hidden">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="h4">Message text</label>
                                <textarea id="showMessage" class="form-control" name="message" style="height: 250px"
                                    placeholder="message"
                                    autocomplete="off" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="h4">recipient</label>
                                <div id="recipients"></div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-primary text-uppercase" style="letter-spacing: 0.1em;" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="application/javascript">
    function openModal()
    {
        $("#message").removeClass('is-invalid');
        $("#message").val("");
        $("#msgErr").removeClass('d-block');
        $('#create-modal-lg').modal('show');
    }

    function openShowModal($notifyId)
    {
        $("#showMessage").val($(".jsNotify_"+ $notifyId +"_message").text().trim());
        $("#recipients").html('');
        $("input[name='notify_"+$notifyId+"_recipients[]']").each(function() {
            let itemHtml = "<span class=\"badge badge-info mr-2\">"+ $(this).val() +"</span>";
            $("#recipients").append(itemHtml);
        });
        
        $('#show-modal-lg').modal('show');
    }

    function closeModal($modalId)
    {
        $('#'+$modalId).modal('hide');
    }

    function doSubmit()
    {
        var message = $("#message").val();
        if(message != "") {
            $("#publishBtn").attr('disabled', true);
            $("#create-form").submit();
        } else {
            $("#message").addClass('is-invalid');
            $("#msgErr").addClass('d-block');
            return false;
        }
    }

</script>
@endsection