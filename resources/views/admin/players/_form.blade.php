<div class="form-group">
    <label>نام</label>
    <input type="text" name="first_name" class="form-control" value="{{old('first_name') ?? $player->first_name}}">
    @component('components.validation',['field' => 'first_name'])
    @endcomponent
</div>

<div class="form-group">
    <label>نام خانوادگی</label>
    <input type="text" name="last_name" class="form-control" value="{{old('last_name') ?? $player->last_name}}">
    @component('components.validation',['field' => 'last_name'])
    @endcomponent
</div>

<div class="form-group">
    <label>سن</label>
    <input type="number" name="age" class="form-control" value="{{old('age') ?? $player->age}}">
    @component('components.validation',['field' => 'age'])
    @endcomponent
</div>

<div class="form-group">
    <label>جنیست</label>
    <select name="gender" class="form-control">
        <option value="male" {{$player->gender === 'male' ? 'selected' : ''}}>پسر</option>
        <option value="female" {{$player->gender === 'female' ? 'selected' : ''}}>دختر</option>
    </select>
    @component('components.validation',['field' => 'last_name'])
    @endcomponent
</div>

<div class="form-group">
    <label>بیوگرافی</label>
    <textarea name="bio" class="form-control">{{old('bio') ?? $player->bio}}</textarea>
    @component('components.validation',['field' => 'bio'])
    @endcomponent
</div>
