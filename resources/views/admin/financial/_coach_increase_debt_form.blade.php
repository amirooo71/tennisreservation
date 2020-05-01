@component('components.portletWithoutFooter',['title' => 'فرم افزایش حساب مربی'])

    <form action="{{route('admin.financial.increase_balance',$coach)}}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label>مبلغ به تومان</label>
            <input type="number" class="form-control" name="amount">
            @component('components.validation',['field' => 'amount'])
            @endcomponent
        </div>
        <div>
            <button class="btn btn-success">ذخیره</button>
        </div>

    </form>

@endcomponent