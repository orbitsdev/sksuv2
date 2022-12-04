



<x-mail::message>
# NEW PASSWORD REQUEST


<x-mail::panel>
<p> {{ $user->email}}</p>
</x-mail::panel>
{{--  <img src="http://127.0.0.1:8000/assets/sksu1.png" alt="sksu.png" width="90" height="90">  --}}

<x-mail::button :url="$set_new_password_url">
    GO TO TO PAGE 
</x-mail::button>

<hr>
If you having trouble redirecting to the set new passwrod page <br> you can copy and pasre the  url  below and and paste it to your browser 
<br>
<br>

<a href="{{$set_new_password_url  }}" style="display:block"> {{ $set_new_password_url}} </a> <br>

<hr>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
