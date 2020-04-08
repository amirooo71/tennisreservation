<div class="form-group row">
    <div class="col-md-6 required">
        <label class="control-label">نام کلاب</label>
        <input name="name" type="text" class="form-control" placeholder="مثال: کلاب تنیس ویمبلدون"
               value="{{old('name') ?? $club->name}}">
        @component('components.validation',['field' => 'name'])
        @endcomponent
    </div>
    <div class="col-md-6 required">
        <label class="control-label">تعداد زمین تنیس های کلاب</label>
        <input name="courts_count" type="number" class="form-control" placeholder="مثال: 6"
               value="{{old('courts_count') ?? $club->courts_count}}">
        @component('components.validation',['field' => 'courts_count'])
        @endcomponent
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4 required">
        <label class="control-label">ساعت شروع به کار کلاب</label>
        <input name="opening_time" type="text" class="form-control"
               data-provide="timepicker"
               data-minute-step="60"
               data-default-time="06:00"
               data-show-meridian="false" value="{{old('opening_time') ?? $club->opening_time}}">
        @component('components.validation',['field' => 'opening_time'])
        @endcomponent
    </div>
    <div class="col-md-4 required">
        <label class="control-label">ساعت اتمام کار کلاب</label>
        <input name="closing_time" type="text" class="form-control"
               data-provide="timepicker"
               data-minute-step="60"
               data-default-time="23:00"
               data-show-meridian="false" data-explicit-mode="false"
               value="{{old('closing_time') ?? $club->closing_time}}">
        @component('components.validation',['field' => 'closing_time'])
        @endcomponent
    </div>
    <div class="col-md-4 required">
        <label class="control-label">مدت زمان کنسلی</label>
        <input name="cancellation_time" type="number" class="form-control" placeholder="مثال: 12"
               value="{{old('cancellation_time') ?? $club->cancellation_time}}">
        <span class="form-text text-muted">بازیکن تا چند ساعت قبل از زمان رزرو امکان کنسل کردن را دارد</span>
        @component('components.validation',['field' => 'cancellation_time'])
        @endcomponent
    </div>
</div>

<div class="form-group form-group-last row">
    <div class="col-md-6">
        <label>توضیحات تکمیلی کلاب</label>
        <textarea class="form-control" name="description" rows="5"
                  placeholder="چند خط درباره ی کلاب و امکانات آن توضیح دهید">{{old('description') ?? $club->description}}
    </textarea>
        @component('components.validation',['field' => 'description'])
        @endcomponent
    </div>
</div>

