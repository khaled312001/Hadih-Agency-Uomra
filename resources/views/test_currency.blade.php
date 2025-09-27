<!DOCTYPE html>
<html>
<head>
    <title>Test Currency</title>
</head>
<body>
    <h1>Currency Test</h1>
    
    <h2>Testing CurrencyHelper directly:</h2>
    <p>SAR: <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage('SAR') }}" alt="SAR" style="width: 24px; height: 24px;"></p>
    <p>USD: <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage('USD') }}" alt="USD" style="width: 24px; height: 24px;"></p>
    <p>EUR: <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage('EUR') }}" alt="EUR" style="width: 24px; height: 24px;"></p>
    <p>AED: <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage('AED') }}" alt="AED" style="width: 24px; height: 24px;"></p>
    <p>INVALID: <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage('INVALID') }}" alt="INVALID" style="width: 24px; height: 24px;"></p>
    
    <h2>Testing with packages:</h2>
    @foreach(\App\Models\UmrahPackage::all() as $package)
        <p>{{ $package->name_ar }} - {{ $package->currency }}: 
           <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($package->currency) }}" alt="{{ $package->currency }}" style="width: 24px; height: 24px;">
        </p>
    @endforeach
</body>
</html>
