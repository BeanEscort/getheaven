<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    <ul class="nav nav-pills mt-3 mb-3" role="tablist">
                        <li class="nav-item">
                            <a href="#roles_content" class="nav-link {{ $tab == 'roles' ? 'active' : '' }}"
                                wire:click="$set('tab','roles')" data-toggle="pill" role="tab">
                                <i class="la la-user la-lg">FUNÇÕES</i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#permissoes_content" class="nav-link {{ $tab == 'permissoes' ? 'active' : '' }}"
                                wire:click="$set('tab','permissoes')" data-toggle="pill" role="tab">
                                <i class="la la-user la-lg">PERMISSÕES</i>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @if($tab == 'roles')
                        @include("livewire.permissoes.roles")
                        @else
                        @include("livewire.permissoes.permissoes")
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showRole(role) {
    var data = JSON.parse(role)
    $('#roleName').val(data['name'])
    $('#roleId').val(data['id'])
}

function clearRoleSelected() {
    $('#roleName').val('')
    $('#roleId').val(0)
    $('#roleName').focus()
}

function showPermissao(permission) {
    var data = JSON.parse(permission)
    $('#permissaoName').val(data['name'])
    $('#permissaoId').val(data['id'])
}

function clearPermissionSelected() {
    $('#permissaoName').val('')
    $('#permissaoId').val(0)
    $('#permissaoName').focus()
}

function Confirm(id, eventName) {
    swal({
            title: 'CONFIRMAR',
            text: 'CONFIRMA A EXCLUSÃO DO REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
        },
        function() {

            window.livewire.emit(eventName, id)
            toastr.success('info', 'Registro eliminado com êxito')
            $('#permissaoName').val('')
            $('#permissaoId').val(0)
            $('#roleName').val('')
            $('#roleId').val(0)

            swal.close()
        })
}

function AtribuirRoles() {
    var rolesList = []
    $('#tblRoles').find('input[type=checkbox]:checked').each(function() {
        rolesList.push($(this).attr('data-name'))
    })

    if (rolesList.length < 1) {
        toastr.error('', 'Selecione pelo menos uma função')
        return;
    }
    if ($('#userId option:selected').val() == 'Selecione') {
        toastr.error('', 'Selecione um usuário')
        return;
    }

    window.livewire.emit('AtribuirRoles', rolesList)

}

function AtribuirPermissoes() {
    var permissoesList = []
    $('#tblPermissoes').find('input[type=checkbox]:checked').each(function() {
        permissoesList.push($(this).attr('data-name'))
    })

    if (permissoesList.length < 1) {
        toastr.error('', 'Selecione pelo menos uma permissão')
        return;
    }

    if( $('#roleSelected option:selected').val() == 'Selecione'){
        toastr.error('','Selecione uma função')
        return;
    }

    window.livewire.emit('AtribuirPermissoes', permissoesList, $('#roleSelected option:selected').val())

}

document.addEventListener('DOMContentLoaded', function() {
    window.livewire.on('ativarTab', tabName => {
        var tab = "[href='" + tabName + "']"
        $(tab).tab('show')
    })

    window.livewire.on('msg-ok', msgText => {
        $('#permissaoName').val('')
        $('#permissaoId').val(0)
        $('#roleName').val('')
        $('#roleId').val(0)
    })
    $('body').on('click','.check-all', function(){
        var state = $(this).is(':checked') ? true : false
        $('#tblPermissoes').find('input[type=checkbox]').each(function(e) {
            $(this).prop('checked', state)
        })
    })
})
</script>
