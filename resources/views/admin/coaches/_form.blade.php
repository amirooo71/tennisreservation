<div class="form-group">
    <label>نام</label>
    <input name="first_name" type="text" class="form-control"
           value="{{old('first_name') ?? $coach->first_name}}">
    @component('components.validation',['field' => 'first_name'])
    @endcomponent
</div>

<div class="form-group">
    <label>نام خانوادگی</label>
    <input name="last_name" type="text" class="form-control"
           value="{{old('last_name') ?? $coach->last_name}}">
    @component('components.validation',['field' => 'last_name'])
    @endcomponent
</div>

<div class="form-group">
    <label>جنسیت</label>
    <select name="gender" class="form-control">
        <option value="male" {{$coach->gender == 'male' ? 'selected' : ''}}>آقا</option>
        <option value="female" {{$coach->gender == 'female' ? 'selected' : ''}}>خانم</option>
    </select>
    @component('components.validation',['field' => 'gender'])
    @endcomponent
</div>

<div class="form-group">
    <label class="checkbox">
        <input type="checkbox" name="is_club_coach" {{$coach->is_club_coach ? 'checked' : ''}}>
        <span></span>
        مربی باشگاه
    </label>
</div>

<div class="form-group">
    <button class="btn btn-success">ذخیره</button>
</div>
