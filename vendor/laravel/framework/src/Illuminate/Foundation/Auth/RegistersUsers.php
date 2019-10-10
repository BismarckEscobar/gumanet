<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));// guarda los registros en la tabla dela BD al mismo tiempo en la variable User

        /*$this->guard()->login($user);//se logea con el nuevo usuario creado

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());// si datos de usuarios existen carga pagina con nuevo usuario si no carga la pagina que esta en la funcion redirect($this->redirectPath())*/
                        return redirect($this->redirectPath());// ***nueva linea de codigo por Ennio*** cuando se guardaden datos  de usuario se redirige a la pagina del home en este caso el dashboard, siempre con el mismo usuario que creo el nuevo registro
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
