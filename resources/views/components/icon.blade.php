@props(['name' => '', 'class' => 'h-5 w-5'])

@if($name)
    @svg('heroicon-'.$name, $class)
@endif