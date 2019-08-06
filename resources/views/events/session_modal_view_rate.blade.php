<legend>Avaliação da Sessão</legend>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="active">Sessão</th>
        <th class="active">{{$session->name}}</th>
    </tr>
    <tr>
        <th class="active">Usuário</th>
        <td class="active">{{$rate->user->name}}</td>
    </tr>
    <tr>
        <th class="active">Média de Avaliações</th>
        <td class="active">{{$rate->average}}</td>
    </tr>
    </thead>
    <tbody>

    <tr>
        <th colspan="100%" class="text-center">Avaliações</th>
    </tr>
    @foreach($rate->user_rates as $user_rate)
        <tr>
         <th colspan="100%">{{$user_rate->type_rate->title}}</th>
        </tr>

        <tr>
            <td>{{$user_rate->comment}}</td>
            <td>{{$user_rate->star_count}} <i class="fa fa-star"></i></td>
        </tr>
    @endforeach
    </tbody>
</table>