<?php

use App\Mail\Notificacao;
use App\Models\Atividade;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::match(["get", "post"], '/', function (Request $request) {
    $i = 2;
    if (Auth::check()) {
        return redirect("/inicio");
    }
    if ($request->all()) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('inicio');
        } else {
            $i = 0;
        }
    }

    return view('login', ["ok" => $i]);
})->name("login");

Route::match(["get", "post"], '/nova-conta', function (Request $request) {
    $i = 2;
    if (Auth::check()) {
        return redirect("/inicio");
    }
    if ($request->all()) {
        if (strlen($request->password) < 8) {
            return redirect()->back()->with("msg_erro", "A palavrapasse deve ter no mínimo 8 caracteres")->with("nome", $request->nome)->with("email", $request->email);
        }

        if ($request->password !== $request->cpassword) {
            return redirect()->back()->with("msg_erro", "A palavrapasse deve ser igual a de confirmação")->with("nome", $request->nome)->with("email", $request->email);
        }

        if (User::where("email", $request->email)->exists()) {
            return redirect()->back()->with("msg_erro", "A palavrapasse deve ser igual a de confirmação")->with("nome", $request->nome)->with("email", $request->email);
        }

        User::insert([
            "nome" => $request->nome,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $assunto = "Registo na APP OGTP";
        $variaveis = [
            "texto" => "Bem-vindo a APP OGTP, a sua conta foi criada com sucesso. por favor faça login na APP"
        ];

        Mail::to($request->email)
            ->send(new Notificacao("OGTP | " . $assunto, $variaveis));

        return redirect("/")->with("msg_ok", "Registado com sucesso, faça login");
    }
    return view('nova-conta', ["ok" => $i]);
})->name("nova-conta");



Route::match(["get", "post"], '/recuperar', function (Request $request) {
    $i = 2;
    if (Auth::check()) {
        return redirect("/inicio");
    }
    if ($request->all()) {
        if (!User::where("email", $request->email)->exists()) {
            return redirect()->back()->with("msg_erro", "Conta não encontrada")->with("email", $request->email);
        }
        $password = "" . rand(10000111, 99999999);
        User::where("email", $request->email)->update([
            "password" => bcrypt($password)
        ]);

        $assunto = "Recuperação de conta na APP OGTP";
        $variaveis = [
            "texto" => "A sua conta foi recuperada com sucesso, utiliza a nova palavrapasse para efetuar o login: <b>" . $password . "</b>"
        ];

        Mail::to($request->email)
            ->send(new Notificacao("OGTP | " . $assunto, $variaveis));

        return redirect("/")->with("msg_ok", "Conta recuperada com sucesso, faça login");
    }
    return view('recuperar', ["ok" => $i]);
})->name("recuperar");



Route::get('logout', function () {
    Auth::logout();
    return redirect("/");
})->name('logout');

Route::middleware("auth")->get("/inicio", function () {
    return view('privado.inicio', ["actividades" => Atividade::where("user_id", Auth::user()->id)->orderby("prioridade", "desc")->get()]);
});


Route::middleware("auth")->match(["get", "post"], "/nova-actividade/{id?}", function (Request $request, $id = 0) {


    if ($request->all()) {
        if ($request->data_inicio > $request->data_fim) {
            return redirect()->back()->with("msg_erro", "Datas inválidas")->with("estado", $request->estado)->with("nome", $request->nome)->with("prioridade", $request->prioridade)->with("data_inicio", $request->data_inicio)->with("data_fim", $request->data_fim);
        }
        $post = $request->except("_token");
        $post["user_id"] = Auth::user()->id;
        unset($post["update"]);
        if (isset($request->update) && $request->update != 0) {
            Atividade::where("id", $request->update)->update($post);
            return redirect("/inicio")->with("msg_ok", "Actividade atualizada com sucesso");
        } else {
            Atividade::create($post);
            return redirect("/inicio")->with("msg_ok", "Actividade registada com sucesso");
        }
    }
    if ($id != 0) {
        return view('privado.nova-actividade', ["update" => $id, "dados" => Atividade::find($id)]);
    }

    return view('privado.nova-actividade');
});

Route::middleware("auth")->post("/remover_actividade", function (Request $request) {
    Atividade::where("id", $request->id)->delete();
    return redirect()->back()->with("msg_ok", "Actividade removida com sucesso");
});



Route::middleware("auth")->get("/tarefas/{id}", function ($atividade) {
    Session()->put("atividade", $atividade);
    return view('privado.tarefas', ["atividade_id" => $atividade, "tarefas" => Tarefa::where("atividade_id", $atividade)->orderby("prioridade", "desc")->get()]);
});


Route::middleware("auth")->match(["get", "post"], "/nova-tarefa/{id?}", function (Request $request, $id = 0) {


    if ($request->all()) {
        if ($request->data_inicio > $request->data_fim) {
            return redirect()->back()->with("msg_erro", "Datas inválidas")->with("estado", $request->estado)->with("nome", $request->nome)->with("prioridade", $request->prioridade)->with("data_inicio", $request->data_inicio)->with("data_fim", $request->data_fim)->with("hora_inicio", $request->hora_inicio)->with("hora_fim", $request->hora_fim);
        }
        $post = $request->except("_token");
        $post["user_id"] = Auth::user()->id;
        unset($post["update"]);
        if (isset($request->update) && $request->update != 0) {
            Tarefa::where("id", $request->update)->update($post);
            return redirect("/tarefas" . "/" . Session()->get("atividade", 0))->with("msg_ok", "Tarefa atualizada com sucesso");
        } else {
            Tarefa::create($post);
            return redirect("/tarefas" . "/" . Session()->get("atividade", 0))->with("msg_ok", "Tarefa registada com sucesso");
        }
    }
    if ($id != 0) {
        return view('privado.nova-tarefa', ["atividade_id" => Session()->get("atividade", 0), "update" => $id, "dados" => Tarefa::find($id)]);
    }

    return view('privado.nova-tarefa', ["atividade_id" => Session()->get("atividade", 0)]);
});

Route::middleware("auth")->post("/remover_tarefa", function (Request $request) {
    Tarefa::where("id", $request->id)->delete();
    return redirect()->back()->with("msg_ok", "Tarefa removida com sucesso");
});


Route::middleware("auth")->get("/remover-tarefa/{id}", function ($id) {
    Tarefa::where("id", $id)->delete();
    return redirect()->back()->with("msg_ok", "Tarefa removida com sucesso");
});



Route::middleware("auth")->get("/remover-atividade/{id}", function ($id) {
    Atividade::where("id", $id)->delete();
    return redirect()->back()->with("msg_ok", "Atividade removida com sucesso");
});




Route::middleware("auth")->post("/alterar_dados", function (Request $request) {
    $post = [
        "nome" => $request->nome,
        "email" => $request->email
    ];

    if (strlen($request->pw) > 0 && $request->pw !== $request->cpw) {
        return redirect()->back()->with("msg_erro", "Palavra-passe e a confirmação devem ser iguais");
    } elseif (strlen($request->pw) > 0 && strlen($request->pw) < 8) {
        return redirect()->back()->with("msg_erro", "Palavra-passe deve ter no mínimo 8 caracteres");
    } else {
        $post["password"] = bcrypt($request->pw);
    }

    User::where("id", Auth::user()->id)->update($post);
    return redirect("/inicio")->with("msg_ok", "Dados Alterados com sucesso");
});


Route::middleware("auth")->get("/alterar_dados", function (Request $request) {
    return view('privado.alterar_dados');
});
