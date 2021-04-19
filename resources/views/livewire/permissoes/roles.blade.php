<div class="tab-pane fade {{ $tab == 'roles' ? 'show active' : '' }}" id="roles_content" role="tabpanel">
    <div class="row mt-5">
        <div class="col-sm-12 col-md-7 col-lg-7">
            <h6 class="text-center"><b>Lista de Funções</b></h6>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="la la-remove la-lg"></i>
                    </span>
                </div>
                <input type="text" id="roleName" class="form-control" autocomplete="off">
                <input type="hidden" id="roleId">
                <div class="input-group-prepend">
                    <span class="input-group-text"
                        wire:click="$emit('CriarRole',$('#roleName').val(), $('#roleId').val())">
                        <i class="la la-save la-lg"></i>
                    </span>
                </div>
            </div>
        
        <div class="table-responsive">
            <table id="tblRoles" class="table table-bordered table-hover table-striped table-checkable table-higlight-head mb-4">
                <thead>
                    <tr>
                        <th class="text-center">DESCRIÇÃO</th>
                        <th class="text-center">USUÁRIOS</th>
                        <th class="text-center">AÇÕES</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $r)
                    <tr>
                        <td>{{$r->name}}</td>
                        <td class="text-center">{{\App\Models\User::role($r->name)->count() }}</td>
                        <td class="text-center">
                            <span style="cursor: pointer;" onClick="showRole('{{$r}}')">
                                <i class="la la-edit la-2x text-center"></i>
                            </span>

                            @if(\App\Models\User::role($r->name)->count() <=0 ) 
                                <a href="javascript:void(0)"
                                onClick="Confirm('{{$r->id}}','destroyRole')" 
                                title="Eliminar função"><i
                                    class="la la-trash la-2x text-center"></i>
                                </a>
                                @endif
                        </td>
                        <td class="text-center">
                            <div class="n-check" id="divRoles">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input data-name="{{$r->name}}" type="checkbox"
                                        {{$r->checked == 1 ? 'checked' : ''}}
                                        class="new-control-input checkbox-rol">
                                    <span class="new-control-indicator"></span>
                                    Atribuir
                                </label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-12 col-md-5 col-lg-5">
        <h6 class="text-left"><b>Escolha o Usuário</b></h6>
        <div class="input-group">
            <select wire:model="userSelected" id="userId" class="form-control">
                <option value="Selecionar">Selecionar</option>
                @foreach($usuarios as $u)
                <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="button" onclick="AtribuirRoles()" class="btn btn-primary mt-4">Atribuir Função</button>
    </div>
</div>
