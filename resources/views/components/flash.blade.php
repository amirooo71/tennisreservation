@if (flash()->message)
    <div class="alert alert-{{flash()->class}} fade show" role="alert">
        <div class="alert-icon">
            @if(flash()->class === 'warning')
                <i class="flaticon-warning"></i>
            @else
                <i class="flaticon-questions-circular-button"></i>
            @endif
        </div>
        <div class="alert-text"> {{ flash()->message }}</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    <i class="la la-close"></i>
                </span>
            </button>
        </div>
    </div>
@endif