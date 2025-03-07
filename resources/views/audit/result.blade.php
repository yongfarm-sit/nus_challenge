<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script> <!-- Marked.js -->
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 md:w-1/2">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-4">CSV Analysis Summary</h1>

        <div class="bg-gray-50 p-4 rounded border">
            <h2 class="text-lg font-semibold text-gray-700">AI-Generated Summary:</h2>
            <div id="summary" class="text-gray-600 mt-2"></div> <!-- This will hold formatted Markdown -->
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('audit.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
                Upload Another File
            </a>
        </div>
    </div>

    <script>
        let rawSummary = `{{ $summary }}`;
        // Convert Markdown to HTML and display it
        document.getElementById('summary').innerHTML = marked.parse(rawSummary);
    </script>

</body>
</html>
