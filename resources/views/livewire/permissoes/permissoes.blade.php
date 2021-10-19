<div class="tab-pane fade {{ $tab == 'permissoes' ? 'show active' : '' }}" id="permissoes_content" role="tabpanel">
    <div class="row mt-5">
        <div class="col-sm-12 col-md-7 col-lg-7">
            <h6 class="text-center"><b>Permissões do Sistema</b></h6>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="la la-remove la-lg"></i>
                    </span>
                </div>
                <input type="text" id="permissaoName" class="form-control" autocomplete="off">
                <input type="hidden" id="permissaoId">
                <div class="input-group-prepend">
                    <span class="input-group-text"
                        wire:click="$emit('CriarPermissao',$('#permissaoName').val(), $('#permissaoId').val())">
                        <i class="la la-save la-lg"></i>
                    </span>
                </div>
            </div>
        
        <div class="table-responsive">
            <table id="tblPermissoes"
                class="table table-bordered table-hover table-striped table-checkable table-higlight-head mb-4">
                <thead>
                    <tr>
                        <th class="text-center">DESCRIÇÃO</th>
                        <th class="text-center">Função <br>com a permissão</th>
                        <th class="text-center">AÇÕES</th>
                        <th class="text-center">
                            <div class="n-check">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input check-all">
                                    <span class="new-control-indicator"></span>TODOS
                                </label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissoes as $p)
                    <tr>
                        <td>{{$p->name}}</td>
                        <td class="text-center">{{\App\Models\User::permission($p->name)->count() }}</td>
                        <td class="text-center">
                            <span style="cursor: pointer;" onClick="showPermissao('{{$p}}')">
                                <i class="la la-edit la-2x text-center"></i>
                            </span>

                            @if(\App\Models\User::permission($p->name)->count() <=0 ) 
                            <a href="javascript:void(0)"
                                onClick="Confirm('{{$p->id}}','destroyPermissao')" title="Eliminar permissão"><i
                                    class="la la-trash la-2x text-center"></i>
                                </a>
                                @endif
                        </td>
                        <td class="text-center">
                            <div class="n-check" id="divPermissoes">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input data-name="{{$p->name}}" type="checkbox"
                                        {{$p->checked == 1 ? 'checked' : ''}}
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
        <h6 class="text-left"><b>Escolha a Função</b></h6>
        <div class="input-group">
            <select wire:model="roleSelected" id="roleSelected" class="form-control">
                <option value="Selecionar">Selecionar</option>
                @foreach($roles as $r)
                <option value="{{$r->id}}">{{$r->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="button" onclick="AtribuirPermissoes()" class="btn btn-primary mt-4">Atribuir Permissões</button>
    </div>
</div>
