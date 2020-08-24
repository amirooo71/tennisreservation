<div class="form-group">
    <label>کورت</label>
    <select name="court_id" class="form-control">
        @foreach($courts as $court)
            <option value="{{$court->id}}"
                {{$court->id === $fixBooking->court_id ? 'selected' : ''}}>{{$court->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>نام رزرو کننده</label>
    <input name="renter_name"
           type="text"
           class="form-control"
           value="{{old('renter_name') ?? $fixBooking->renter_name}}">
    @component('components.validation',['field' => 'renter_name'])
    @endcomponent
</div>

<div class="form-group">
    <lavel>نام مربی</lavel>
    <select name="coach_id" id="" class="form-control">
        @foreach(\App\Coach::all() as $coach)
            <option value="{{$coach->id}}">{{$coach->first_name}} {{$coach->last_name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>روز هفته</label>
    <select name="day" id="day" class="form-control">
        <option value="شنبه" {{$fixBooking->day === 'شنبه' ? 'selected' : ''}}>شنبه</option>
        <option value="یکشنبه" {{$fixBooking->day === 'یکشنبه' ? 'selected' : ''}}>یکشنبه</option>
        <option value="دوشنبه" {{$fixBooking->day === 'دوشنبه' ? 'selected' : ''}}>دوشنبه</option>
        <option value="سه شنبه" {{$fixBooking->day === 'سه شنبه' ? 'selected' : ''}}>سه شنبه</option>
        <option value="چهارشنبه" {{$fixBooking->day === 'چهارشنبه' ? 'selected' : ''}}>چهارشنبه</option>
        <option value="پنج شنبه" {{$fixBooking->day === 'پنج شنبه' ? 'selected' : ''}}>پنج شنبه</option>
        <option value="جمعه" {{$fixBooking->day === 'جمعه' ? 'selected' : ''}}>جمعه</option>
    </select>
    @component('components.validation',['field' => 'day'])
    @endcomponent
</div>

<div class="form-group">
    <label>ساعت</label>
    <select name="time" id="time" class="form-control">
        @foreach($openingHours as $hour)
            <option value="{{$hour}}" {{$fixBooking->time === $hour ? 'selected' : ''}}>@faNum($hour,false)</option>
        @endforeach
    </select>
    @component('components.validation',['field' => 'time'])
    @endcomponent
</div>

<div class="form-group">
    <label>نام شاگرد</label>
    <input name="partner_name"
           type="text"
           class="form-control"
           value="{{old('partner_name') ?? $fixBooking->partner_name}}">
    @component('components.validation',['field' => 'partner_name'])
    @endcomponent
</div>

<div class="form-group">
    <button class="btn btn-success">ذخیره</button>
</div>
