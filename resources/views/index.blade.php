@extends('app')

@section('content')

@include('components/filter')
@include('components/table')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Дождитесь загрузки DOM
    $(document).ready(function() {
        // На чекбоксы добавим обработчик события change
        $('input[name="tags[]"]').change(function() {
            updateTable();
            updateURL();
        });
    });

    function updateTable() {
        var selectedTags = $('input[name="tags[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            url: '/filter',
            type: 'GET',
            data: {
                tags: selectedTags
            },
            success: function(response) {
                // Заменяем содержимое таблицы на обновленное из response
                $('table').replaceWith(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function updateURL() {
        var selectedTags = $('input[name="tags[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        // Обновляем URL, добавляя выбранные теги
        var newURL = '/?tags=' + selectedTags.join(',');
        history.pushState(null, null, newURL);
    }
</script>


@endsection