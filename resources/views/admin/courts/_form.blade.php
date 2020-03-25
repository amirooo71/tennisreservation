<div class="form-group">
    <label>نام</label>
    <input class="form-control" type="text" name="name" placeholder="مثال: زمین شماره ۱"
           value="{{old('name') ?? $court->name}}">
    @component('components.validation',['field' => 'name'])
    @endcomponent
</div>

<div class="form-group">
    <label>نوع زمین</label>
    <select name="type" class="form-control">
        <option value="clay" {{$court->type === 'clay' ? 'selected' : ''}}>خاک</option>
        <option value="hard" {{$court->type === 'hard' ? 'selected' : ''}}>هارد</option>
        <option value="grass" {{$court->type === 'grass' ? 'selected' : ''}}>چمن</option>
    </select>
    @component('components.validation',['field' => 'type'])
    @endcomponent
</div>

<div class="form-group">
    <label>قیمت هر ساعت اجاره زمین به تومان</label>
    <input type="number" name="price" class="form-control" value="{{old('price') ?? $court->price}}">
    @component('components.validation',['field' => 'price'])
    @endcomponent
</div>

<div class="form-group">
    <label class="kt-checkbox">
        <input type="checkbox" name="is_indoor" {{$court->is_indoor ? 'checked' : ''}}> سر پوشیده
        <span></span>
    </label>
</div>

<div class="form-group">
    <label class="kt-checkbox">
        <input type="checkbox" name="is_center" {{$court->is_center ? 'checked' : ''}}> سنتر کورت
        <span></span>
    </label>
</div>
