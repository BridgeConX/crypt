<?php

class EncryptionTest extends TestCase
{

    const ENCRYPTION_KEY = 'qs507BAzsLffB2cCaAD2uyHDuIeskTb6';

    const DECRYPTED_VALUE = 'I can encrypt!';

    const ENCRYPTED_VALUE = 'eyJpdiI6ImVmemdIeTd6TUVuYU9FaW5ERGxVbHc9PSIsInZhbHVlIjoiSmJnY0lPSXQxUm82U0JJS2xcL1RzN2VDb1JIVEhFRDZhOW1oWjZkOVY5anc9IiwibWFjIjoiOWI3MDU2YWFlMjQzMWI4NjQ3NTM4YzI5NmZhM2FhNDYxY2M3N2ExM2E0NzY5NDdmOWQyZGFkZTRiMjQ1YjE5YSJ9';

    public function testCanEncrypt()
    {
        $this->get('/encrypt?key=' . $this::ENCRYPTION_KEY . '&value=' . $this::DECRYPTED_VALUE)
          ->seeJson([
              'status' => true,
              'decrypted' => $this::DECRYPTED_VALUE,
          ]);
    }

    public function testCanDecrypt()
    {
        $this->get('/decrypt?key=' . $this::ENCRYPTION_KEY . '&value=' . $this::ENCRYPTED_VALUE)
          ->seeJson([
            'status' => true,
            'decrypted' => $this::DECRYPTED_VALUE,
          ]);
    }

}
