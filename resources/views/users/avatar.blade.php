@if ($user->getPrimaryPhoto())
<img src="/{!! str_replace(' ','%20',$user->getPrimaryPhoto()->thumbnail) !!}" alt="{{ $user->name}}"  class="avatar">
@else
<img src="/images/avatar-placeholder-generic.jpg" alt="{{ $user->name}}"  class="avatar">
@endif