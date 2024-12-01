<?php

use Ivy\Setting;
use Ivy\Template;
use Spatie\SchemaOrg\Schema;

function add_schema_data(): void
{
    $schema = Schema::BlogPosting()
        ->name(Setting::$stash->name->value)
        ->headline(Setting::$stash->title->value)
        ->datePublished(Setting::$stash->date->value)
        ->author(Schema::Person()->name(Setting::$stash->author->value));
    echo $schema->toScript();
}

Template::hooks()->add_action('end_head_action', 'add_schema_data');