<x-guest-layout>
<div class="mx-2">
	@if ($message = Session::get('success'))
              <div class="flex justify-center mt-2">
    			<div class="flex justify-between w-1/2 px-4 py-2 text-green-600 bg-green-100 rounded">
        			<p><strong>Obrigado! </strong> {{$message}}</p><span><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                		viewBox="0 0 24 24" stroke="currentColor">
                		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            			</svg></span>
    			</div>
		</div>
		{{--<div class="alert alert-success alert-dismissible mb-4" role="alert">
        		<button type="button" classe="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></button>
        		<strong>Obrigado! </strong> {{$message}}
		</div> --}}
	@endif

    <a href="https://wa.me/5562993207235" target="_blank"><svg viewBox="0 0 32 32" class="whatsapp-ico"><path d=" M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z" fill-rule="evenodd"></path></svg></a>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-4 mx-auto flex">
            <div class="sm:p-2 p-1 sm:w-1/5">
                <img class="w-4/5 object-cover h-4/5 mx-auto object-center block" src="images/favicon-126x126.png" />
            </div>
	    
        </div>
    </section>

    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-14 mx-auto">
            <div class="flex flex-wrap -m-12">
                <div class="p-12 sm:w-1/2 flex flex-col items-start">

                    <h1 class="sm:text-8xl text-5xl md:w-auto md:px-auto title-font font-x3 text-gray-900 mt-1 mb-4"><strong>GetHeaven</strong></h1>
                    <h1 class="sm:text-5xl text-2xl title-font font-x3 text-gray-900 mt-4 mb-4">Soluções inteligentes para <br>Gestão de Cemitérios</h1>

                </div>

            </div>
        </div>
    </section>

    <section class="text-gray-600 body-font relative">
        <div class="flex ml-1 mt-3.5 md:w-full">
            <div class="flex flex-col w-11/12">
                <div class="hidden md:flex bg-imgcemiterio bg-cover sm:h-64 h-44 w-full md:items-stretch md:items-center relative"></div>
                <img class="md:hidden object-cover object-center block flex h-44 w-full relative" src="/images/bg-img-cemiterio.png">
            </div>
        </div>
    </section>

    <section class="text-gray-600 body-font">
        <div class="flex flex-col text-center w-full mb-1">
            <h1 class="sm:text-6xl text-5xl font-medium title-font mt-10 text-gray-900">Apresentação Real</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Prontos para entregar serviços de excelência no apoio ao luto!</p>
        </div>
        <div class="sm:w-screen sm:h-96 mx-auto shadow-md overflow-hidden sm:w-96 sm:bg-blue mt-10">
             <div class="sm:flex">
                <div class="sm:flex-shrink-0">
                    <iframe class="md:w-screen sm:h-96" src="https://player.vimeo.com/video/594896558" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen responsive=true></iframe>
                </div>
            </div>
        </div>
    </section>


    <section class="text-gray-600 body-font">
        <div class="container m-0 px-2 py-1 mx-auto mt-10">
            <div class="flex flex-wrap mt-10">
                <div class="p-1 sm:w-1/2 flex flex-col items-start">
                    <span class="inline-block py-1 px-2 rounded bg-indigo-50 text-indigo-500 text-xs font-medium tracking-widest">Nosso Lema</span>
                    <h1 class="sm:text-5xl text-4xl title-font font-lg text-gray-900 mt-4 mb-2">+Tecnologia e <br>+Soluções para <br>+Qualidade</h1>

                </div>
                <div class="p-1 sm:w-1/2 flex flex-col items-start">

                    <h2 class="sm:text-5xl text-3xl title-font font-medium text-gray-900 mt-2 mb-4"></h2>
                    <p class="leading-relaxed mb-2 text-justify">Tradicionalmente as informações de jazigos nos cemitérios, encontram-se em livros de registros, nem sempre bem conservados. Governos anteriores, via de regra, também não dispensaram o merecido tratamento às informações, não raro, havendo duplicidade de escrituração e dificuldade na localização de túmulos.

                        Por isso, nasceu a GETHEAVEN para solucionar questões de tais naturezas, utilizando técnicas de processamento, para melhorias na administração dos cemitérios.</p>

                </div>
            </div>
        </div>
    </section>

    <section class="text-gray-600 body-font">
        <div class="container px-2 py-24 mx-auto flex flex-wrap-reverse md:flex-wrap items-center">
            <div class="sm:w-1/2 rounded-lg overflow-hidden sm:mr-1 p-1 flex items-center justify-start relative">

                <div class="relative flex flex-wrap py-6 rounded shadow-md">
                    <div class="lg:w-1/2 px-3">
                        <h2 class="sm:text-3xl text-2xl title-font font-semibold text-gray-900 tracking-widest text-xs">Raimundo</h2>
                        <p class="mt-1"></p>
                    </div>
                    <div class="lg:w-1/2 px-3 mt-4 lg:mt-0">
                        <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">E-MAIL</h2>
                        <a class="text-indigo-500 leading-relaxed">raimundo.colombo@gmail.com</a>
                        <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs mt-4">TELEFONE</h2>
                        <p class="leading-relaxed">(61) 9 9228-5188</p>
                    </div>

                    <div class="lg:w-1/2 px-3 mt-4">
                        <h2 class="sm:text-3xl text-2xl title-font font-semibold text-gray-900 tracking-widest text-xs">Marcos</h2>
                        <p class="mt-1"></p>
                    </div>
                    <div class="lg:w-1/2 px-3 mt-4 lg:mt-4">
                        <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">E-MAIL</h2>
                        <a class="text-indigo-500 leading-relaxed">marcos_prog@yahoo.com.br</a>
                        <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs mt-4">TELEFONE</h2>
                        <p class="leading-relaxed">(62) 9 9320-7235</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-2 flex flex-col md:ml-auto w-full mt-10 md:mt-0">

            <form action="{{ route('apresentacao')  }}" class="w-full" method="POST">
                @csrf

                <h1 class="sm:text-3xl text-2xl text-center text-gray-900 text-lg mb-1 font-medium title-font">Entre em contato</h1>
                <p class="leading-relaxed mb-5 text-center text-gray-600">Seu endereço de e-mail não será compartilhado com ninguém!</p>

                @if ($message = Session::get('success'))
                <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                    <p class="font-bold">Obrigado!</p>
                    <p class="text-sm">{{$message}}</p>
                </div>
                @endif
                <div class="relative mb-4">
                    <label for="name" class="leading-7 text-sm text-gray-600">Nome *</label>
                    <input type="text" id="name" name="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    @error('name')
                        <div class="block w-full text-red-600">{{$message}}</div>
                    @enderror
                </div>
                <div class="relative mb-4">
                    <label for="email" class="leading-7 text-sm text-gray-600">E-mail *</label>
                    <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    @error('email')
                        <div class="block w-full text-red-600">{{$message}}</div>
                    @enderror
                </div>
                <div class="relative mb-4">
                    <label for="message" class="leading-7 text-sm text-gray-600">Mensagem *</label>
                    <textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    @error('message')
                        <div class="block w-full text-red-600">{{$message}}</div>
                    @enderror
                </div>
                <button type="submit" class="md:transition md:duration-150 md:ease-in-out text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Enviar</button>

            </form>
            </div>
        </div>
      </section>

    <script src="https://player.vimeo.com/api/player.js"></script>
</div>

</x-guest-layout>
