<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $players = Player::paginate(30);

        return view('admin.players.index', compact('players'));

    }

    /**
     * @param Player $player
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Player $player)
    {

        return view('admin.players.profile',compact('player'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.players.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->getValidate();

        Player::create($data);

        flash('بازیکن با موفقیت ثبت شد.', 'success');

        return back();

    }

    /**
     * @param Player $player
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Player $player)
    {
        return view('admin.players.edit', compact('player'));
    }

    /**
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Player $player)
    {
        $data = $this->getValidate();

        $player->update($data);

        flash('بازیکن با موفقیت ویرایش شد.', 'success');

        return back();

    }

    /**
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Player $player)
    {
        $player->delete();

        flash('بازیکن با موفقیت حذف شد.', 'success');

        return back();
    }

    /**
     * @return array
     */
    public function getValidate(): array
    {
        $data = \request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number_one' => 'required',
            'learning_price' => 'required',
            'gender' => 'required',
            'contact_number_two' => 'nullable',
            'email' => 'nullable',
            'age' => 'nullable',
            'bio' => 'nullable'
        ]);

        return $data;
    }

}
