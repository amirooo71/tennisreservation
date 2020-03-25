<div class="form-group">
    <label>نام کلاب</label>
    <input name="name" type="text" class="form-control" placeholder="مثال: کلاب تنیس ویمبلدون"
           value="{{old('name') ?? $club->name}}">
    @component('components.validation',['field' => 'name'])
    @endcomponent
</div>
<div class="form-group">
    <label>تعداد زمین تنیس های کلاب</label>
    <input name="courts_count" type="text" class="form-control" placeholder="مثال: ۶"
           value="{{old('courts_count') ?? $club->courts_count}}">
    @component('components.validation',['field' => 'courts_count'])
    @endcomponent
</div>
<div class="form-group">
    <label>ساعت شروع به کار کلاب</label>
    <input name="opening_time" type="text" class="form-control" data-provide="timepicker"
           data-show-meridian="false" value="{{old('opening_time') ?? $club->opening_time}}">
    @component('components.validation',['field' => 'opening_time'])
    @endcomponent
</div>
<div class="form-group">
    <label>ساعت اتمام کار کلاب</label>
    <input name="closing_time" type="text" class="form-control" data-provide="timepicker"
           data-show-meridian="false" value="{{old('closing_time') ?? $club->closing_time}}">
    @component('components.validation',['field' => 'closing_time'])
    @endcomponent
</div>
<div class="form-group form-group-last">
    <label>توضیحات تکمیلی کلاب</label>
    <textarea class="form-control" name="description" rows="5"
              placeholder="چند خط درباره ی کلاب و امکانات آن توضیح دهید">{{old('description') ?? $club->description}}
    </textarea>
    @component('components.validation',['field' => 'description'])
    @endcomponent
</div>