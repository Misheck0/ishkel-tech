@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Expense Tracker</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('expenses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        @csrf
        <input type="date" name="date" class="border p-2 rounded" value="{{ $currentDate}}" required>
        <input type="number" step="0.01" name="amount" placeholder="Amount" class="border p-2 rounded" required>
        <div class="flex gap-2 items-center">
            <!-- Text Input with Datalist Autocomplete -->
            <input 
              type="text" 
              name="category" 
              placeholder="Type or select a category" 
              class="border p-2 rounded flex-grow" 
              list="categoryOptions"
              required
            >
          
            <!-- Dropdown for Quick Selection -->
            <select 
              class="border p-2 rounded bg-white cursor-pointer"
              onchange="this.previousElementSibling.value = this.value"
            >
              <option value="" selected disabled>Choose...</option>
              <option value="Food">Food</option>
              <option value="Transportation">Transportation</option>
              <option value="Housing">Housing</option>
              <option value="Utilities">Utilities</option>
              <option value="Entertainment">Entertainment</option>
              <option value="Healthcare">Healthcare</option>
              <option value="Education">Education</option>
              <option value="Other">Other</option>
            </select>
          
            <!-- Datalist for Autocomplete Suggestions -->
            <datalist id="categoryOptions">
              <option value="Food">
              <option value="Transportation">
              <option value="Housing">
              <option value="Utilities">
              <option value="Entertainment">
              <option value="Healthcare">
              <option value="Education">
              <option value="Other">
            </datalist>
          </div>
        <input type="text" name="description" placeholder="Description" class="border p-2 rounded">
        <button class="col-span-1 md:col-span-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Expense</button>
    </form>

    <!-- Category Filter -->
    <form method="GET" class="mb-4">
        <select name="category" onchange="this.form.submit()" class="border p-2 rounded">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Expense Table -->
    <div class="overflow-x-auto">
        <table class="w-full border rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Amount</th>
                    <th class="p-2 text-left">Profit</th>
                    <th class="p-2 text-left">Category</th>
                    <th class="p-2 text-left">Description</th>
                  {{-- new column --}}
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr class="border-t">
                        <td class="p-2">{{ $expense->date }}</td>
                        <td class="p-2">ZMW {{ number_format($expense->amount, 2) }}</td>
                        <td class="p-2">
                            @if($expense->category === 'invoice order')
                                ZMW {{ number_format($expense->invoice->total_amount - $expense->amount , 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-2">{{ $expense->category }}</td>
                        <td class="p-2">{{ $expense->description }}</td>
                       
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-2 text-center text-gray-500">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
            
        </table>
    </div>

    <!-- Chart 
    <div class="mt-8">
        <canvas id="expenseChart" height="100"></canvas>
    </div> -->
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    fetch('{{ route("expenses.chart") }}')
        .then(res => res.json())
        .then(data => {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Expenses by Category',
                        data: data.amounts,
                        backgroundColor: 'rgba(34,197,94,0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
</script>
@endsection
