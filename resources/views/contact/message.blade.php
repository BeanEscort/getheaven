@component('mail::message')
<h2>Você recebeu um novo contato</h2>

<p><strong>NOME: </strong> {{ $data['name'] }}</p>
<p><strong>EMAIL: </strong> {{ $data['email'] }}</p>
<p><strong>MENSAGEM: </strong>
<pre>
{{ $data['message'] }}
</pre>
</p>
@endcomponent
