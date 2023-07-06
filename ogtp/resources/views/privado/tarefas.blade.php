@include('privado.header')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header"> <a href="{{ url('inicio') }}">Voltar</a> |<b>Tarefas</b></h5>
        @if (Session::get('msg_ok'))
            <div class="alert alert-success" role="alert" style="text-align: center">
                {{ Session::get('msg_ok') }}
            </div>
        @endif
        <div class="table-responsive text-nowrap">
            @php
                $prio = [
                    1 => 'Imediata',
                    2 => 'Alta',
                    3 => 'Normal',
                    4 => 'Baixa',
                ];
            @endphp
            <table class="table" style="font-size: 8pt">
                <thead>
                    <tr>
                        <th><a class="btn btn-info" style="padding: 2px; font-size: 8pt"
                                href="{{ url('nova-tarefa') }}">Criar Tarefa</a></th>
                        <th>Inicio/Fim</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($tarefas as $item)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                <strong>{{ $item->nome }}</strong><br>
                                <span class="badge bg-label-warning me-1">{{ $prio[$item->prioridade] }}</span><br>
                                <span class="badge bg-label-primary me-1">{{ $item->estado }}</span>
                            </td>

                            <td><span>{{ $item->data_inicio }}<br>{{ $item->data_fim }}</span></td>

                            <td>
                                <div class="row">
                                    <a href="{{ url('/nova-tarefa', $item->id) }}"><i class="bx bx-edit-alt me-1"></i>
                                        Edit / Alterar Estado</a>
                                    <a href="{{ url('/remover-tarefa', $item->id) }}"><i
                                            class="bx bx-edit-alt me-1"></i> Remover</a>

                                    {{--
                                    <a href="#" onclick="$('#idA').val('{{ $item->id }}')"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                            class="bx bx-trash me-1"></i> Delete</a>
--}}
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remover Actividade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{ url('remover_tarefa') }}">
                                    @csrf
                                    <div class="modal-body">
                                        Deseja remover?
                                        <input hidden name="id" id="idA" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Não</button>
                                        <button type="submit" class="btn btn-danger">Sim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                </tbody>
            </table>
        </div>
    </div>


</div>
@include('privado.footer')
