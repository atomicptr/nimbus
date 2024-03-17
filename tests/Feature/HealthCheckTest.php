<?php

it('can request health check', function () {
    $response = $this->get('/up');

    $response->assertStatus(200);
});
