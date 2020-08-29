<?php


Route::get('/playground', function () {


    $current = \Hekmatinasser\Verta\Verta::instance('22:01:00');

    $time = \Hekmatinasser\Verta\Verta::instance('21:30:00');

    dd($time->diffMinutes($current));


});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {


    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard.index');

    Route::get('clubs', 'Admin\ClubsController@index')->name('admin.clubs.index');
    Route::get('clubs/create', 'Admin\ClubsController@create')->name('admin.clubs.create');
    Route::get('clubs/{club}/edit', 'Admin\ClubsController@edit')->name('admin.clubs.edit');
    Route::post('clubs', 'Admin\ClubsController@store')->name('admin.clubs.store');
    Route::patch('clubs/{club}', 'Admin\ClubsController@update')->name('admin.clubs.update');
    Route::delete('clubs/{club}', 'Admin\ClubsController@delete')->name('admin.clubs.delete');

    Route::get('clubs/{club}/courts', 'Admin\CourtsController@index')->name('admin.courts.index');
    Route::get('clubs/{club}/courts/create', 'Admin\CourtsController@create')->name('admin.courts.create');
    Route::get('clubs/{club}/courts/{court}/edit', 'Admin\CourtsController@edit')->name('admin.courts.edit');
    Route::get('clubs/{club}/courts/{court}', 'Admin\CourtsController@delete')->name('admin.courts.delete');
    Route::post('clubs/{club}/courts', 'Admin\CourtsController@store')->name('admin.courts.store');
    Route::patch('clubs/{club}/courts/{court}', 'Admin\CourtsController@update')->name('admin.courts.update');

    Route::get('bookings', 'Admin\BookingsController@index')->name('admin.bookings.index');
    Route::get('bookings/canceled', 'Admin\BookingsController@canceled')->name('admin.bookings.canceled');
    Route::get('bookings/{booking}/cancel/is-valid-time', 'Admin\BookingsController@isValidTimeForCanceling')->name('admin.bookings.isValidTimeForCanceling');
    Route::post('bookings', 'Admin\BookingsController@store')->name('admin.bookings.store');
    Route::patch('bookings/{booking}/cancel', 'Admin\BookingsController@cancel')->name('admin.bookings.cancel');
    Route::patch('bookings/{booking}/pay', 'Admin\BookingsController@pay')->name('admin.bookings.pay');
    Route::delete('bookings/{booking}/delete', 'Admin\BookingsController@delete')->name('admin.bookings.delete');

    Route::get('ajax/coaches', 'Admin\CoachesController@getCoaches')->name('admin.coaches.getCoaches');
    Route::get('ajax/coach/bookings', 'Admin\CoachesController@getBookings')->name('admin.coaches.getBookings');

    Route::get('bookings/part-time/{partTimeBooking}/cancel/is-valid-time', 'Admin\PartTimeBookingsController@isValidTimeForPartTimeCanceling')->name('admin.bookings.isValidTimeForPartTimeCanceling');
    Route::post('bookings/{booking}/part-time', 'Admin\PartTimeBookingsController@store')->name('admin.bookings.part_time.store');
    Route::patch('bookings/{partTimeBooking}/part-time/pay', 'Admin\PartTimeBookingsController@pay')->name('admin.bookings.part_time.pay');
    Route::patch('bookings/{partTimeBooking}/part-time/cancel', 'Admin\PartTimeBookingsController@cancel')->name('admin.bookings.part_time.cancel');
    Route::delete('bookings/{partTimeBooking}/part-time/delete', 'Admin\PartTimeBookingsController@delete')->name('admin.bookings.part_time.delete');


    Route::get('hours/bookings', 'Admin\HoursBookingsController@index')->name('admin.hours_bookings.index');
    Route::post('hours/bookings', 'Admin\HoursBookingsController@store')->name('admin.hours_bookings.store');

    Route::get('fix/bookings', 'Admin\FixBookingsController@index')->name('admin.fix_bookings.index');
    Route::get('fix/bookings/create', 'Admin\FixBookingsController@create')->name('admin.fix_bookings.create');
    Route::get('fix/bookings/{fixBooking}/edit', 'Admin\FixBookingsController@edit')->name('admin.fix_bookings.edit');
    Route::get('fix/bookings/{fixBooking}/delete', 'Admin\FixBookingsController@delete')->name('admin.fix_bookings.delete');
    Route::post('fix/bookings', 'Admin\FixBookingsController@store')->name('admin.fix_bookings.store');
    Route::patch('fix/bookings/{fixBooking}', 'Admin\FixBookingsController@update')->name('admin.fix_bookings.update');


    Route::get('ajax/activity/date-time/dates', 'Admin\ActivityDateAndTimeController@dates');
    Route::get('ajax/activity/date-time/hours', 'Admin\ActivityDateAndTimeController@hours');


    Route::get('ajax/booking/note', 'Admin\BookingNoteController@index');
    Route::post('ajax/booking/note', 'Admin\BookingNoteController@store');

    Route::get('ajax/courts', 'Admin\CourtsController@courts');


    Route::get('ajax/court/bookings', 'Admin\BookingsController@getCourtBookings')->name('admin.bookings.getCourtBookings');


    Route::get('coaches', 'Admin\CoachesController@index')->name('admin.coaches.index');
    Route::get('coaches/create', 'Admin\CoachesController@create')->name('admin.coaches.create');
    Route::get('coaches/{coach}/edit', 'Admin\CoachesController@edit')->name('admin.coaches.edit');
    Route::get('coaches/{coach}/delete', 'Admin\CoachesController@delete')->name('admin.coaches.delete');
    Route::post('coaches', 'Admin\CoachesController@store')->name('admin.coaches.store');
    Route::patch('coaches/{coach}', 'Admin\CoachesController@update')->name('admin.coaches.update');

    Route::get('financial/creditors', 'Admin\FinancialController@creditors')->name('admin.creditors.index');
    Route::get('financial/coaches/debt', 'Admin\FinancialController@coachesDebtList')->name('admin.financial.coaches_debt_list');
    Route::get('financial/coaches/{coach}/pay', 'Admin\FinancialController@coachPayForm')->name('admin.financial.coach_pay_form');
    Route::patch('financial/coaches/{coach}/pay', 'Admin\FinancialController@storeCoachPay')->name('admin.financial.coach_pay');
    Route::patch('financial/coaches/{coach}/increase-balance', 'Admin\FinancialController@increaseCoachBalance')->name('admin.financial.increase_balance');
    Route::get('financial/debtors', 'Admin\FinancialController@debtors')->name('admin.debtors.index');
    Route::get('financial/payments', 'Admin\FinancialController@payments')->name('admin.payments.index');
    Route::patch('financial/creditors/{creditor}/refund', 'Admin\FinancialController@refundCreditorMoney')->name('admin.refund_creditors.index');
    Route::patch('financial/debtors/{debtor}/pay', 'Admin\FinancialController@debtorPaid')->name('admin.debtor_pay.index');

    Route::get('statistic/revenue', 'Admin\StatisticsController@revenue')->name('admin.statistics.revenue');
    Route::get('statistic/bookings', 'Admin\StatisticsController@bookings')->name('admin.statistics.bookings');
    Route::get('statistic/canceled', 'Admin\StatisticsController@canceled')->name('admin.statistics.canceled');

    Route::get('ajax/statistic/revenue/weekly', 'Admin\StatisticsController@revenueWeekly');
    Route::get('ajax/statistic/revenue/monthly', 'Admin\StatisticsController@revenueMonthly');
    Route::get('ajax/statistic/revenue/annually', 'Admin\StatisticsController@revenueAnnually');

    Route::get('ajax/statistic/bookings/weekly', 'Admin\StatisticsController@bookingsWeekly');
    Route::get('ajax/statistic/bookings/monthly', 'Admin\StatisticsController@bookingsMonthly');
    Route::get('ajax/statistic/bookings/annually', 'Admin\StatisticsController@bookingsAnnually');

    Route::get('ajax/statistic/canceled/weekly', 'Admin\StatisticsController@canceledWeekly');
    Route::get('ajax/statistic/canceled/monthly', 'Admin\StatisticsController@canceledMonthly');
    Route::get('ajax/statistic/canceled/annually', 'Admin\StatisticsController@canceledAnnually');

    Route::get('players', 'Admin\PlayersController@index')->name('admin.players.index');
    Route::get('players/create', 'Admin\PlayersController@create')->name('admin.players.create');
    Route::get('players/{player}/edit', 'Admin\PlayersController@edit')->name('admin.players.edit');
    Route::get('players/{player}/delete', 'Admin\PlayersController@delete')->name('admin.players.delete');
    Route::post('players/store', 'Admin\PlayersController@store')->name('admin.players.store');
    Route::patch('players/{player}/update', 'Admin\PlayersController@update')->name('admin.players.update');


});
