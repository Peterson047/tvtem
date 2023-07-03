<?php include_once('functions.php'); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
  href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
  rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.1.min.js"></script>

<style type="text/css">
  body {
    background-image: url(../assets/BGS.png);
    color: #f5f5f5;
    font-family: 'Rubik', sans-serif;
  }

  table {
    background: #1e3465;
    box-shadow: 0px 5px 15px 0px rgba(0, 0, 0, 0.6);
    padding: 5px;
    border-radius: 10px;
    margin-bottom: 30px;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  h1,
  p {
    text-align: center;
    color: #f5f5f5;
  }

  .count {
    font-size: 100px;
    color: #fff;
    letter-spacing: 1px;
    text-shadow: 2px 2px 4px #000000;
  }

  .table-bordered th,
  .table-bordered td {
    font-size: 20px;
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #f5f5f500;
    transition: all 0.3s;
  }

  .table-bordered th {
    color: #FFF;
    font-size: 30px;
    border-bottom: 1px solid #f5f5f5;
  }

  .g1 {
    background-color: #58a6ff;
    color: #21272e;
    padding: 10px;
    text-transform: uppercase;
  }

  .table-bordered td:hover {
    background: #1e3465;
    border-radius: 10px;
  }

  @media (max-width:768px) {

    .col-md-9,
    .col-md-3 {
      padding: 0
    }
  }

  @media (max-width: 991px) {
    .col-md-3.pull-right {
      float: none !important;
    }
  }
</style>
</br>
</br>
<div class="col-md-4">
  <table class="table table-bordered">
    <tbody>
      <tr class="g2">
        <th class="g1">ARAÇATUBA</th>
      </tr>
      <tr>
        <td>
          <h1>
            <div class="count" id="active-users">
            </div>
          </h1>
          <p>Usuários Ativos no Site</p>
          <br>
          <div id="devices">
          </div>
        </td>
      </tr>
    </tbody>
  </table>

  <table class="table menor1" id="result-pages">
    <thead>
      <tr>

        <th>Páginas</th>
        <th>Usuários</th>

      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>

  <table class="table menor1" id="result-sources">
    <thead>
      <tr>

        <th>Tipo de Busca</th>
        <th>Usuários</th>
        </th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>


</div>
</div>

<script type="text/javascript">
  // Define um intervalo de tempo para chamar a função "call()" a cada 95000 milissegundos (95 segundos)
  setInterval(function () {
    call();
  }, 95000);

  // Define a função "call()" que faz várias chamadas para a função "get()" com diferentes ações como parâmetro
  function call() {
    get('pages');
    get('users');
    get('devices');
    get('sources');
    get('countries');
    get('browser');
    get('os');
  }
  // Chama a função "call()" uma vez ao carregar o script
  call();

  // Define a função "get()" que faz uma requisição AJAX para um arquivo chamado "ajax.php" com uma ação e uma visualização como parâmetros
  function get(action) {
    var view = '<?php echo VIEW; ?>';
    $.ajax({
      url: "ajax.php?action=" + action + '&view=' + view,
      type: 'get',
      success: function (res) {
        // Verifica a ação e atualiza o conteúdo de diferentes elementos HTML com o resultado da requisição
        if (action == 'pages') {
          $("#result-pages tbody").html(res);
        }
        else if (action == 'users') {
          $("#active-users").html(res);
        }
        else if (action == 'devices') {
          $("#devices").html(res);
        }
        else if (action == 'sources') {
          $("#result-sources tbody").html(res);
        }
        else if (action == 'countries') {
          $("#countries-sources tbody").html(res);
        }
        else if (action == 'browser') {
          $("#browser-sources tbody").html(res);
        }
        else if (action == 'os') {
          $("#os-sources tbody").html(res);
        }
      }
    });
  }

  // Define um manipulador de evento para quando um elemento com a classe "open-link" for clicado
  $(document).on('click', '.open-link', function () {
    // Obtém o atributo "data-link" do elemento clicado e adiciona-o ao domínio
    link = $(this).attr('data-link');
    link = '<?php echo DOMAIN; ?>' + link;
    // Abre o link em uma nova guia ou janela
    window.open(link, '_blank');
  });
</script>