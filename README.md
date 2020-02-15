# Laravel on my way

Um projeto modelo de como implementar camadas de serviço em projetos Laravel, sem a utilização de Repository Pattern, 
em qualquer versão do Laravel.

## Introdução

Qual a melhor forma de estruturarmos com um projeto Laravel, garantindo o seu crescimento e a sua manutenibilidade?

Essa é uma pergunta comum, quando pensamos em projetos de grande porte. Nesse repositório, exponho uma das abordagens utilizadas 
por mim, em alguns dos projetos Laravel que já trabalhei. 

É importante ressaltar que não considero a existência de uma maneira correta de trabalhar com o Laravel. A melhor forma, no meu ponto de vista,
é aquela que funciona para o projeto, e para a equipe, fundamentalmente, garantindo a manutenção, extensão, funcionamento e 
segurança do projeto. Logo, então, o que apresento aqui, é algo que atende à essas premissas. 

## O Problema

Laravel é um framework acessível, poderoso, que fornece uma série de ferramentas de fácil manuseio, para que desenvolvedores 
trabalhem no desenvolvimento de suas aplicações. Ele utiliza o padrão MVC (Model View Controller), onde seu model utiliza o 
padrão de design (design pattern) Active Record e é desse ponto que partiremos.

O Active Record é um padrão de design que dá o poder de auto-salvamento a um Model. Entenda como objetos com super poderes.
Cada instância de um objeto Active Record representa um registro do banco de dados, onde as suas propriedades são acessadas 
e modificadas por métodos acessores e modificadores, "escondendo", assim, suas propriedades. Digo, escondendo, entre aspas, 
porque, neste padrão, as propriedades que deveriam estar ocultas, podem ser acessadas de forma direta, magicamente, 
exatamente como acontece com o Laravel, com o Rails, Yii e muitos outros frameworks, porém com poderes de auto-criação, 
destruição e muitos outros.

Pensando nisso, se dividirmos a aplicação em camadas, corremos um sério risco do objeto ultrapassar os limites da camada 
e permitir que o model empoderado chegue à camada da aplicação, com poderes para se autodestruir, o que não é uma boa idéia.

Vamos considerar o seguinte caso:

Temos um model chamado ```Note``` que está sendo enviado para a view.

```php
<?php

namespace App\Http\Controllers;

class NotesController extends Controller

public function show($note)
{
    $note = Note::find($note);
    return view('notes.show', compact('note'));
}
```

Na view podemos fazer algo como isso:

```blade
<h1>{{ $note->title }}</h1>
<p>{{ $note->description }}</p>

<?php $note->delete() ?>
```
É estranho fazer isso. Esdrúxulo, eu diria. 

Quem, em sã consciência, faria isso? Embora eu acredite que ninguém vá fazer isso, ainda assim, é possível fazer.

Esse é o problema que tento resolver com esse projeto. Estudo a criação de uma abordagem
onde o poder do model não chegue à camada de serviço da aplicação, existindo, somente, dentro da camada de serviço de domínio.

_Work in progress..._
