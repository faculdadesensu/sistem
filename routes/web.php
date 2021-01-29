<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CadAtendController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContasPagarController;
use App\Http\Controllers\ContasReceberController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HoraController;
use App\Http\Controllers\MovimentacoesController;
use App\Http\Controllers\PainelAtendimentoController;
use App\Http\Controllers\PainelRecepcaoController;
use App\Http\Controllers\RecepController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\SolicitacoesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('movimentacao',                     [MovimentacoesController::class, 'index'])->name('movimentacao.index');
Route::get('comissoes',                        [ComissaoController::class, 'index'])->name('comissao.index');


// Rotas Relatório
Route::get('painel-recepcao/relatorio/movimentacoes',      [RelatorioController::class, 'movimentacoes'])->name('relatorio.index');
Route::get('painel-recepcao/relatorio/comissoes',          [RelatorioController::class, 'comissoes'])->name('comissoes.index');

//Routes atendentes
Route::get('atendentes',                        [CadAtendController::class, 'index'])->name('cadAtend');
Route::post('atendentes',                       [CadAtendController::class, 'insert'])->name('atend.insert');
Route::get('atendentes/inserir',                [CadAtendController::class, 'create'])->name('atend.inserir');
Route::get('atendentes/{item}/edit',            [CadAtendController::class, 'edit'])->name('atend.edit');
Route::put('atendentes/{item}',                 [CadAtendController::class, 'editar'])->name('atend.editar');
Route::delete('atendentes/{item}',              [CadAtendController::class, 'delete'])->name('atend.delete');
Route::get('atendenes/{item}',                  [CadAtendController::class, 'modal'])->name('atend.modal');
Route::get('atendentes/{item}/modal-baixa',     [CadAtendController::class, 'modal_history'])->name('atend.history');


//Routes recepcionistas
Route::get('recep',                [RecepController::class, 'index'])->name('recep.index');
Route::post('recep',               [RecepController::class, 'insert'])->name('recep.insert');
Route::get('recep/inserir',        [RecepController::class, 'create'])->name('recep.inserir');
Route::get('recep/{item}/edit',    [RecepController::class, 'edit'])->name('recep.edit');
Route::put('recep/{item}',         [RecepController::class, 'editar'])->name('recep.editar');
Route::delete('recep/{item}',      [RecepController::class, 'delete'])->name('recep.delete');
Route::get('recep/{item}',         [RecepController::class, 'modal'])->name('recep.modal');

// Routes Service
Route::get('service',                [ServiceController::class, 'index'])->name('service.index');
Route::post('service',               [ServiceController::class, 'insert'])->name('service.insert');
Route::get('service/inserir',        [ServiceController::class, 'create'])->name('service.inserir');
Route::get('service/{item}/edit',    [ServiceController::class, 'edit'])->name('service.edit');
Route::put('service/{item}',         [ServiceController::class, 'editar'])->name('service.editar');
Route::delete('service/{item}',      [ServiceController::class, 'delete'])->name('service.delete');
Route::get('service/{item}',         [ServiceController::class, 'modal'])->name('service.modal');
Route::get('getService/',            [ServiceController::class, 'getService'])->name('getService');

// Routes Horario
Route::get('hora',                [HoraController::class, 'index'])->name('hora.index');
Route::post('hora',               [HoraController::class, 'insert'])->name('hora.insert');
Route::get('hora/inserir',        [HoraController::class, 'create'])->name('hora.inserir');
Route::get('hora/{item}/edit',    [HoraController::class, 'edit'])->name('hora.edit');
Route::put('hora/{item}',         [HoraController::class, 'editar'])->name('hora.editar');
Route::delete('hora/{item}',      [HoraController::class, 'delete'])->name('hora.delete');
Route::get('hora/{item}',         [HoraController::class, 'modal'])->name('hora.modal');

//Route agendas
Route::get('agendas',                [AgendaController::class, 'index'])->name('agendas.index');
Route::post('agendas',               [AgendaController::class, 'insert'])->name('agendas.insert');
Route::get('agendas/inserir',        [AgendaController::class, 'create'])->name('agendas.inserir');
Route::get('agendas/{item}/edit',    [AgendaController::class, 'edit'])->name('agendas.edit');
Route::put('agendas/{item}',         [AgendaController::class, 'editar'])->name('agendas.editar');
Route::delete('agendas/{item}',      [AgendaController::class, 'delete'])->name('agendas.delete');
Route::get('agendas/{item}',         [AgendaController::class, 'modal'])->name('agendas.modal');
Route::post('agendas/busca',         [AgendaController::class, 'busca'])->name('agendas.busca');

//Routes Clientes
Route::get('clientes',                [ClientController::class, 'index'])->name('clientes.index');
Route::post('clientes',               [ClientController::class, 'insert'])->name('clientes.insert');
Route::get('clientes/inserir',        [ClientController::class, 'create'])->name('clientes.inserir');
Route::get('clientes/{item}/edit',    [ClientController::class, 'edit'])->name('clientes.edit');
Route::put('clientes/{item}',         [ClientController::class, 'editar'])->name('clientes.editar');
Route::delete('clientes/{item}',      [ClientController::class, 'delete'])->name('clientes.delete');
Route::get('clientes/{item}',         [ClientController::class, 'modal'])->name('clientes.modal');
Route::get('getClientes/',            [ClientController::class, 'getClientes'])->name('getClientes');

//Routes users
Route::post('/',                       [UserController::class, 'logout'])->name('user.logout');
Route::post('painel',                  [UserController::class, 'login'])->name('login');
Route::delete('user/{item}',           [UserController::class, 'delete'])->name('users.delete');
Route::get('user/{item}',              [UserController::class, 'modal'])->name('users.modal');
Route::get('user',                     [UserController::class, 'index'])->name('users.index');

//Rotas painel admin
Route::get('home-admin',                [AdminController::class, 'index'])->name('admin.index');
Route::put('admin/{user}',              [AdminController::class, 'edit'])->name('admin.edit');

//Rotas painel recepcionista
Route::get('home-recep',                [PainelRecepcaoController::class, 'index'])->name('painel-recep.index');
Route::put('painel-recep/{user}',       [PainelRecepcaoController::class, 'edit'])->name('painel-recep.edit');

//Rotas painel atendimento
Route::get('home-atendimento',                      [PainelAtendimentoController::class, 'index'])->name('painel-atend.index');
Route::put('painel-atendimento/{user}',             [PainelAtendimentoController::class, 'edit'])->name('painel-atend.edit');


//Rotas painel recepcionista - Clientes
Route::get('painel-recepcao/clientes',                [ClientController::class, 'index'])->name('painel-recepcao-clientes.index');
Route::post('painel-recepcao/clientes',               [ClientController::class, 'insert'])->name('painel-recepcao-clientes.insert');
Route::get('painel-recepcao/clientes/inserir',        [ClientController::class, 'create'])->name('painel-recepcao-clientes.inserir');
Route::get('painel-recepcao/clientes/{item}/edit',    [ClientController::class, 'edit'])->name('painel-recepcao-clientes.edit');
Route::put('painel-recepcao/clientes/{item}',         [ClientController::class, 'editar'])->name('painel-recepcao-clientes.editar');
Route::delete('painel-recepcao/clientes/{item}',      [ClientController::class, 'delete'])->name('painel-recepcao-clientes.delete');
Route::get('painel-recepcao/clientes/{item}',         [ClientController::class, 'modal'])->name('painel-recepcao-clientes.modal');

//Rotas painel recepcionista - Agenda
Route::get('painel-recepcao/agendas',                       [AgendaController::class, 'index'])->name('painel-recepcao-agendas.index');
Route::post('painel-recepcao/agendas',                      [AgendaController::class, 'insert'])->name('painel-recepcao-agendas.insert');
Route::get('painel-recepcao/agendas/inserir/',              [AgendaController::class, 'createRecep'])->name('painel-recepcao-agendas.inserir');
Route::get('painel-recepcao/agendas/{item}/edit',           [AgendaController::class, 'edit'])->name('painel-recepcao-agendas.edit');
Route::put('painel-recepcao/agendas/{item}',                [AgendaController::class, 'editar'])->name('painel-recepcao-agendas.editar');
Route::delete('painel-recepcao/agendas/{item}',             [AgendaController::class, 'delete'])->name('painel-recepcao-agendas.delete');
Route::get('painel-recepcao/agendas/{item}',                [AgendaController::class, 'modal'])->name('painel-recepcao-agendas.modal');
Route::post('painel-recepcao/cobrar-agendas/',              [AgendaController::class, 'cobrar'])->name('painel-recepcao-agendas.cobrar');
Route::get('painel-recepcao/cobrar-agendas/{item}',         [AgendaController::class, 'modal_cobrar'])->name('painel-recepcao-agendas.modal-cobrar');

//Rotas painel Atendimento - Agenda
Route::get('painel-atendimentos/agendas',                               [AgendaController::class, 'index'])->name('painel-atendimentos-agendas.index');
Route::post('painel-atendimentos/agendas',                              [AgendaController::class, 'insert'])->name('painel-atendimentos-agendas.insert');
Route::get('painel-atendimentos/agendas/{item}/{item2}/inserir',        [AgendaController::class, 'create'])->name('painel-atendimentos-agendas.inserir');
Route::delete('painel-atendimentos/agendas/{item}/{item2}',             [AgendaController::class, 'delete'])->name('painel-atendimentos-agendas.delete');
Route::get('painel-atendimentos/agendas/{item}/{item2}',                [AgendaController::class, 'modal'])->name('painel-atendimentos-agendas.modal');

//Rotas Constas a receber
Route::delete('painel-recepcao/constas-receber/{item}/delete',                  [ContasReceberController::class, 'delete'])->name('contas-receber.delete');
Route::get('painel-recepcao/contas-receber/{item}',                             [ContasReceberController::class, 'modal'])->name('contas-receber.modal');
Route::get('painel-recepcao/contas-receber',                                    [ContasReceberController::class, 'index'])->name('contas-receber.index');
Route::get('painel-recepcao/constas-receber/{item}/edit',                       [ContasReceberController::class, 'edit'])->name('contas-receber.edit');
Route::put('painel-recepcao/constas-receber/{item}',                            [ContasReceberController::class, 'editar'])->name('contas-receber.editar');
Route::get('painel-recepcao/constas-receber/{item}/modal-baixa',                [ContasReceberController::class, 'modal_baixa'])->name('contas-receber.modal-baixa');
Route::put('painel-recepcao/constas-baixa',                                     [ContasReceberController::class, 'baixa'])->name('contas-receber.baixa');

//Rotas Contas Pagar
Route::get('painel-recepcao/contas-pagar',                          [ContasPagarController::class, 'index'])->name('pagar.index');
Route::post('painel-recepcao/contas-pagar',                         [ContasPagarController::class, 'insert'])->name('pagar.insert');
Route::get('painel-recepcao/contas-pagar/inserir',                  [ContasPagarController::class, 'create'])->name('pagar.inserir');
Route::delete('painel-recepcao/contas-pagar/{item}',                [ContasPagarController::class, 'delete'])->name('pagar.delete');
Route::get('painel-recepcao/contas-pagar/{item}',                   [ContasPagarController::class, 'modal'])->name('pagar.modal');
Route::get('painel-recepcao/constas-pagar/{item}/modal-baixa',      [ContasPagarController::class, 'modal_baixa'])->name('pagar.modal-baixa');
Route::put('painel-recepcao/constas-pagar/baixa',                   [ContasPagarController::class, 'baixa'])->name('pagar.baixa');

//Rotas painel atendentes - Solicitações
Route::get('solicitacoes',                [SolicitacoesController::class, 'index'])->name('solicitacoes.index');
Route::post('solicitacoes',               [SolicitacoesController::class, 'insert'])->name('solicitacoes.insert');
Route::get('solicitacoes/inserir',        [SolicitacoesController::class, 'create'])->name('solicitacoes.inserir');
Route::get('solicitacoes/{item}/edit',    [SolicitacoesController::class, 'edit'])->name('solicitacoes.edit');
Route::put('solicitacoes/{item}',         [SolicitacoesController::class, 'editar'])->name('solicitacoes.editar');
Route::delete('solicitacoes/{item}',      [SolicitacoesController::class, 'delete'])->name('solicitacoes.delete');
Route::get('solicitacoes/{item}',         [SolicitacoesController::class, 'modal'])->name('solicitacoes.modal');

