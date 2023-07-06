@include('privado.header')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">

                    @if (isset($update))
                        <h4 class="mb-2">  <a href="{{ url('/inicio') }}"><span>Voltar</span> | </a>  Actualizar Actividade 👋</h4>
                    @else
                        <h4 class="mb-2"><a href="{{ url('/inicio') }}"><span>Voltar</span> | </a>  Nova Actividade 👋</h4>
                    @endif

                    <form method="post" action="{{ url('nova-actividade') }}" class="mb-3">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Estado</label>
                            <select required class="form-control" name="estado" autocomplete="off">

                                <option {{ Session::get('estado', $dados->estado ?? '') === 'Em curso' ? 'Selected' : '' }}
                                    value="Em curso">Em
                                    curso</option>
                                <option {{ Session::get('estado', $dados->estado ?? '') === 'Alta' ? 'Selected' : '' }}
                                    value="Cancelado">
                                    Cancelado</option>
                                <option
                                    {{ Session::get('estado', $dados->estado ?? '') === 'Concluído' ? 'Selected' : '' }}
                                    value="Concluído">
                                    Concluído</option>
                                <option
                                    {{ Session::get('estado', $dados->estado ?? '') === 'Pendente' ? 'Selected' : '' }}
                                    value="Pendente">
                                    Pendente</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Descrição</label>
                            <input value="{{ Session::get('nome', $dados->nome ?? '') }}" required type="text"
                                class="form-control" name="nome" autocomplete="off" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Prioridade</label>
                            <select required class="form-control" name="prioridade" autocomplete="off">
                                <option value="">Escolher</option>
                                <option
                                    {{ Session::get('prioridade', $dados->prioridade ?? '') === '1' ? 'Selected' : '' }}
                                    value="1">
                                    Imediata</option>
                                <option
                                    {{ Session::get('prioridade', $dados->prioridade ?? '') === '2' ? 'Selected' : '' }}
                                    value="2">Alta
                                </option>
                                <option
                                    {{ Session::get('prioridade', $dados->prioridade ?? '') === '3' ? 'Selected' : '' }}
                                    value="3">
                                    Normal</option>
                                <option
                                    {{ Session::get('prioridade', $dados->prioridade ?? '') === '4' ? 'Selected' : '' }}
                                    value="4">Baixa
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Data inicio</label>
                            <input value="{{ Session::get('data_inicio', $dados->data_inicio ?? '') }}" required
                                type="date" class="form-control" name="data_inicio" autocomplete="off" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Data fim</label>
                            <input required value="{{ Session::get('data_fim', $dados->data_fim ?? '') }}" type="date"
                                class="form-control" name="data_fim" autocomplete="off" />
                        </div>

                        <input hidden value="{{ $update??0 }}" name="update" id="idA" />
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

                        @if (isset($update))
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Actualizar</button>
                            </div>
                        @else
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Criar</button>
                            </div>
                        @endif

                    </form>

                    <p class="text-center">

                        <a href="{{ url('/inicio') }}">
                            <span>Voltar às actividades</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>

@include('privado.footer')
