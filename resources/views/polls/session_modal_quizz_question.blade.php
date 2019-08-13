<style>
    .alternative_content {
        width: 100%;
        height: 150px;
        padding: 1rem;
    }

    .alternative_template {
        display: none;
    }
</style>

<legend>Questão do Quizz</legend>

<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th colspan="100%" class="active">{{$question->content}}</th>
    </tr>
    </thead>
    <tbody>
    {{--    <tr>--}}
    {{--        <th>Alternativa</th>--}}
    {{--        <th>Porcentagem de Escolha</th>--}}
    {{--    </tr>--}}
    @foreach($question->alternatives as $alternative)
        <tr>
            <td>{{$alternative->content}}</td>
            <td>{{$alternative->choice_rate}}%</td>
        </tr>
    @endforeach
    </tbody>
</table>