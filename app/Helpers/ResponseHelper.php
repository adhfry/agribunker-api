<?php

if (!function_exists('apiResponse')) {
    /**
     * Helper untuk response API
     *
     * @param mixed $data Data yang dikembalikan
     * @param string|null $methodObject Format metode:objek, contoh: create:user (opsional)
     * @param bool $isError Status error atau tidak
     * @param string|null $customMessage Pesan kustom (opsional)
     * @return \Illuminate\Http\JsonResponse
     */
    function apiResponse($data = null, $methodObject = null, $isError = false, $customMessage = null)
    {
        // Default message jika methodObject tidak diberikan
        $defaultMessage = $isError ? 'Failed to collect data' : 'Collect data';

        // Jika methodObject diberikan, pecahkan metode:objek menjadi dua bagian
        if ($methodObject) {
            [$method, $object] = explode(':', $methodObject);
            $messages = [
                'create' => [
                    'success' => ucfirst($object) . ' created successfully',
                    'error' => 'Failed to create ' . $object,
                ],
                'read' => [
                    'success' => 'Collect data ' . $object,
                    'error' => 'Failed to collect data ' . $object,
                ],
                'update' => [
                    'success' => ucfirst($object) . ' updated successfully',
                    'error' => 'Failed to update ' . $object,
                ],
                'delete' => [
                    'success' => ucfirst($object) . ' deleted successfully',
                    'error' => 'Failed to delete ' . $object,
                ],
            ];

            // Tentukan pesan berdasarkan metode dan status
            $messageKey = $isError ? 'error' : 'success';
            $message = $messages[$method][$messageKey] ?? $defaultMessage;
        } else {
            // Jika methodObject tidak diberikan, gunakan pesan default
            $message = $defaultMessage;
        }

        // Jika customMessage diberikan, override pesan default
        if ($customMessage) {
            $message = $customMessage;
        }

        // Format response JSON
        return response()->json([
            'status' => $isError ? 'error' : 'success',
            'data' => $data,
            'message' => $message,
        ], $isError ? 400 : 200);
    }
}