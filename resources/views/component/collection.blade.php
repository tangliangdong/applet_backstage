<ul class="collection" id="menu_dishes">
    @foreach ($item->list as $a)
        <li class="collection-item">
            {{$a->dish_name}}
            <a href="#!" class="secondary-content"><i class="material-icons">send</i></a>
        </li>
    @endforeach
</ul>