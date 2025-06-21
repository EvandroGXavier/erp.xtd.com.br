{{--
 * Grid de Contatos Aprimorada
 * Recursos implementados:
 * 1. Seleção em massa com ações (exportar, adicionar a grupo)
 * 2. Links operacionais para WhatsApp, telefone e e-mail
 * 3. Sistema de mostrar/ocultar colunas
 * 4. Ordenação avançada com DataTables
 * 5. Design responsivo e moderno
--}}

@extends('layouts.app')

@section('title', 'Lista de Contatos')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center py-2">
            <h5 class="mb-0">Contatos</h5>
            <div class="d-flex">
                <div class="btn-group btn-group-sm me-2" id="bulk-action-group" style="display: none;">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-check2-square me-1"></i> Ações em Massa
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" id="btn-export-selected"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Exportar Selecionados</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#groupModal"><i class="bi bi-people-fill me-2"></i>Adicionar ao Grupo</a></li>
                    </ul>
                </div>
                <a href="{{ route('contatos.create') }}" class="btn btn-success btn-sm" title="Novo Contato">
                    <i class="bi bi-plus-lg me-1"></i> Novo
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-columns-gap me-1"></i> Colunas
                        </button>
                        <ul class="dropdown-menu" id="column-toggle-menu">
                            <li><a class="dropdown-item toggle-vis" data-column="1">CPF/CNPJ</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="2">Contato</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="3">Celular</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="4">Telefone</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="5">E-mail</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="6">Endereço</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="7">Tipo</a></li>
                            <li><a class="dropdown-item toggle-vis" data-column="8">Cidade</a></li>
                        </ul>
                    </div>
                    <button id="reset-columns" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-arrow-repeat me-1"></i> Redefinir
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2">Busca:</label>
                    <input type="text" id="search-input" class="form-control form-control-sm" style="width: 200px;" placeholder="Digite para filtrar...">
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="contatos-table" class="table table-striped table-hover table-sm mb-0" style="width:100%;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 1%;"><input type="checkbox" id="select-all"></th>
                            <th style="width: 15%;">CPF/CNPJ</th>
                            <th style="width: 20%;">Contato</th>
                            <th style="width: 12%;">Celular</th>
                            <th style="width: 12%;">Telefone</th>
                            <th style="width: 20%;">E-mail</th>
                            <th style="width: 20%;">Endereço</th>
                            <th style="width: 10%;">Tipo</th>
                            <th style="width: 10%;">Cidade</th>
                            <th class="text-center" style="width: 3%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contatos as $c)
                            <tr data-id="{{ $c->id }}">
                                <td class="text-center"><input type="checkbox" class="record-select" value="{{ $c->id }}"></td>
                                <td>{{ $c->cpf_cnpj }}</td>
                                <td>{{ $c->nome }}</td>
                                <td>
                                    @if($c->celular)
                                        @php
                                            $whatsapp = preg_replace('/[^0-9]/', '', $c->celular);
                                            // Remover zeros no início se houver mais de 2 dígitos
                                            if (strlen($whatsapp) > 2 && substr($whatsapp, 0, 1) === '0') {
                                                $whatsapp = substr($whatsapp, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/55{{ $whatsapp }}" target="_blank" class="text-primary" title="Enviar mensagem no WhatsApp">
                                            <i class="bi bi-whatsapp me-1"></i>{{ $c->celular }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($c->fone)
                                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $c->fone) }}" class="text-success" title="Ligar para este número">
                                            <i class="bi bi-telephone me-1"></i>{{ $c->fone }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($c->email)
                                        <a href="mailto:{{ $c->email }}" class="text-info" title="Enviar e-mail">
                                            <i class="bi bi-envelope me-1"></i>{{ $c->email }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($c->endereco)
                                        {{ $c->endereco }}, {{ $c->numero }}
                                        @if($c->complemento)
                                            <small class="text-muted">({{ $c->complemento }})</small>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $c->tipo_pessoa }}</td>
                                <td>{{ $c->cidade }}/{{ $c->uf }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('contatos.edit', $c->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('contatos.destroy', $c->id) }}" method="POST" id="form-delete-{{$c->id}}">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger delete-item" data-id="{{$c->id}}">
                                                        <i class="bi bi-trash me-2"></i>Excluir
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar ao Grupo -->
<div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groupModalLabel">Adicionar Contatos ao Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Selecionar Grupo</label>
                    <select class="form-select" id="group-select">
                        <option value="">Selecione um grupo...</option>
                        <option value="1">Clientes</option>
                        <option value="2">Fornecedores</option>
                        <option value="3">Colaboradores</option>
                        <option value="4">Parceiros</option>
                        <option value="5">Prospectos</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contatos Selecionados</label>
                    <div id="selected-contacts" class="bg-light p-2 rounded" style="min-height: 50px; max-height: 150px; overflow-y: auto;">
                        <small class="text-muted">Nenhum contato selecionado</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-add-to-group">Adicionar ao Grupo</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast de Feedback -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Sucesso</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        cursor: pointer;
    }
    .table-sm th, .table-sm td {
        padding: 0.5rem;
    }
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
    }
    
    /* Badges para tipos de pessoa */
    td:nth-child(8) {
        font-weight: 500;
    }
    td:nth-child(8) {
        color: #0d6efd;
    }
    td:nth-child(8) {
        color: #198754;
    }
    td:nth-child(8) {
        color: #6c757d;
    }
    
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            gap: 10px;
        }
        .card-header > div {
            width: 100%;
            justify-content: center;
        }
        .table-responsive {
            border: none;
        }
        #search-input {
            width: 100% !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicialização do DataTable
        var table = $('#contatos-table').DataTable({
            dom: 'rt<"row"<"col-md-6"i><"col-md-6"p>>',
            ordering: true,
            paging: true,
            pageLength: 25,
            info: true,
            lengthChange: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
            },
            columnDefs: [
                { orderable: false, targets: [0, 9] },
                { searchable: false, targets: [0, 3, 4, 9] },
                { className: 'text-center', targets: [0, 9] }
            ],
            order: [[2, 'asc']]
        });

        // Busca rápida
        $('#search-input').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Seleção em massa
        $('#select-all').click(function() {
            var checked = this.checked;
            $('.record-select').prop('checked', checked);
            toggleBulkActions();
        });

        $('.record-select').change(function() {
            if ($('.record-select:checked').length === $('.record-select').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
            toggleBulkActions();
        });

        function toggleBulkActions() {
            var selectedCount = $('.record-select:checked').length;
            if (selectedCount > 0) {
                $('#bulk-action-group').show();
                updateSelectedContacts();
            } else {
                $('#bulk-action-group').hide();
            }
        }

        // Mostrar/ocultar colunas
        $('.toggle-vis').on('click', function(e) {
            e.preventDefault();
            var column = table.column($(this).attr('data-column'));
            column.visible(!column.visible());
            $(this).toggleClass('text-muted');
        });

        // Redefinir colunas
        $('#reset-columns').click(function() {
            table.columns().visible(true);
            $('.toggle-vis').removeClass('text-muted');
        });

        // Atualizar contatos selecionados no modal
        function updateSelectedContacts() {
            var selectedIds = $('.record-select:checked').map(function() {
                return this.value;
            }).get();
            
            var selectedNames = $('.record-select:checked').closest('tr').find('td:eq(2)').map(function() {
                return $(this).text();
            }).get();
            
            var html = '';
            if (selectedNames.length > 0) {
                html = '<ul class="mb-0">';
                for (var i = 0; i < Math.min(selectedNames.length, 5); i++) {
                    html += '<li><small>' + selectedNames[i] + '</small></li>';
                }
                if (selectedNames.length > 5) {
                    html += '<li><small class="text-primary">+ ' + (selectedNames.length - 5) + ' outros</small></li>';
                }
                html += '</ul>';
            } else {
                html = '<small class="text-muted">Nenhum contato selecionado</small>';
            }
            
            $('#selected-contacts').html(html);
        }

        // Adicionar ao grupo
        $('#btn-add-to-group').click(function() {
            var selectedIds = $('.record-select:checked').map(function() {
                return this.value;
            }).get();
            
            var groupId = $('#group-select').val();
            
            if (!groupId) {
                alert('Selecione um grupo');
                return;
            }
            
            if (selectedIds.length === 0) {
                alert('Selecione pelo menos um contato');
                return;
            }
            
            // Simulação da ação
            showToast(selectedIds.length + ' contatos adicionados ao grupo selecionado');
            $('#groupModal').modal('hide');
            
            // Em produção, substituir pelo código real:
            /*
            $.ajax({
                url: '/contatos/add-to-group',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    group_id: groupId,
                    contact_ids: selectedIds
                },
                success: function(response) {
                    if (response.success) {
                        showToast(response.message);
                        $('#groupModal').modal('hide');
                    } else {
                        alert('Erro: ' + response.message);
                    }
                },
                error: function() {
                    alert('Erro ao processar a solicitação');
                }
            });
            */
        });

        // Exportar selecionados
        $('#btn-export-selected').click(function(e) {
            e.preventDefault();
            var selectedIds = $('.record-select:checked').map(function() {
                return this.value;
            }).get();
            
            if (selectedIds.length === 0) {
                alert('Selecione pelo menos um contato');
                return;
            }
            
            // Simulação da ação
            alert('Exportando ' + selectedIds.length + ' contatos...');
            
            // Em produção, substituir pelo código real:
            /*
            var form = $('<form>', {
                method: 'POST',
                action: '/contatos/export-selected'
            });
            
            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}'
            }));
            
            $.each(selectedIds, function(index, id) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'ids[]',
                    value: id
                }));
            });
            
            $('body').append(form);
            form.submit();
            form.remove();
            */
        });

        // Edição por duplo clique
        $('#contatos-table tbody').on('dblclick', 'tr', function() {
            var id = $(this).data('id');
            window.location.href = '/contatos/' + id + '/edit';
        });

        // Exclusão com confirmação
        $('.delete-item').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var form = $('#form-delete-' + id);
            
            if (confirm('Tem certeza que deseja excluir este contato?')) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function() {
                        table.row($('[data-id="' + id + '"]')).remove().draw();
                        showToast('Contato excluído com sucesso!');
                    },
                    error: function() {
                        showToast('Erro ao excluir contato!', 'error');
                    }
                });
            }
        });

        // Exibir toast de feedback
        function showToast(message, type = 'success') {
            var toast = $('#liveToast');
            toast.find('.toast-header')
                .removeClass('bg-success bg-danger')
                .addClass(type === 'success' ? 'bg-success' : 'bg-danger');
            toast.find('.toast-body').text(message);
            toast.toast('show');
            
            setTimeout(function() {
                toast.toast('hide');
            }, 5000);
        }
        
        // Abrir modal de grupo quando solicitado
        $('#groupModal').on('show.bs.modal', function() {
            updateSelectedContacts();
        });
    });
</script>
@endpush