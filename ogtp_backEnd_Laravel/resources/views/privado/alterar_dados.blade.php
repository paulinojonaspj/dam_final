@include('privado.header')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">


                    <h4 class="mb-2"> <a href="{{ url('/inicio') }}"><span>Voltar</span> | </a> Actualizar Dados do
                        Perfil 👋</h4>


                    <form method="post" action="{{ url('alterar_dados') }}" class="mb-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input value="{{ Auth::user()->nome }}" required type="text" class="form-control"
                                name="nome" autocomplete="off" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input value="{{ Auth::user()->email }}" required type="email" class="form-control"
                                name="email" autocomplete="off" />
                        </div>
                        <div class="row" style="background-color: rgb(210, 216, 244)">
                            <p style="color: brown"><b>Nota:</b> Se não pretende alterar a palavra passe deixe em branco
                            </p>
                            <div class="mb-3">
                                <label class="form-label">Palavrapasse</label>
                                <input type="password" class="form-control" name="pw" autocomplete="off" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirmar Palavrapasse</label>
                                <input type="password" class="form-control" name="cpw" autocomplete="off" />
                            </div>
                        </div>
                        @if (Session::get('msg_erro'))
                            <div class="alert alert-danger" role="alert" style="text-align: center">
                                {{ Session::get('msg_erro') }}
                            </div>
                        @endif

                        @if (Session::get('msg_ok'))
                            <div class="alert alert-success" role="alert" style="text-align: center">
                                {{ Session::get('msg_ok') }}
                            </div>
                        @endif


                        <div class="mb-3" style="margin-top: 10px">
                            <button class="btn btn-primary d-grid w-100" type="submit">Actualizar</button>
                        </div>


                    </form>

                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>

@include('privado.footer')
