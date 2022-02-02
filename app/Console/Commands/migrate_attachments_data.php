<?php

namespace App\Console\Commands;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\CommentAttachment;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class migrate_attachments_data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_attachments_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrating data from PostAttachment and CommentAttachment models to a polymorphic Attachment model that maintains a one-to-many relationship with Post and Comment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $flag = 0;
        $this->info("Espere que culmine la ejecución.");
        do {
            $ifExist = Schema::hasTable('attachments');
            if ($ifExist) {
                $flag++;
                $postsAttachments = PostAttachment::all();
                $this->info("Migrando la informacion de PostAttachment hacia Attachment.");
                foreach ($postsAttachments as $itemPostAttachment) {
                    //Aqui tuve un error
                    // Attachment::firstOrCreate(['url' => $itemPostAttachment->url, 'attachment_id' => $itemPostAttachment->post_id, 'attachment_type' => PostAttachment::class, 'created_at' => $itemPostAttachment->created_at,  'updated_at' => $itemPostAttachment->updated_at]);
                    Attachment::firstOrCreate(['url' => $itemPostAttachment->url, 'attachmentable_id' => $itemPostAttachment->post_id, 'attachmentable_type' => Post::class]);
                }

                $commentsAttachments = CommentAttachment::all();
                $this->info("Migrando la informacion de CommentAttachment hacia Attachment.");
                foreach ($commentsAttachments as $itemCommentAttachment) {
                    //Aqui tuve un error
                    // Attachment::firstOrCreate(['url' => $itemCommentAttachment->url, 'attachment_id' => $itemCommentAttachment->comment_id, 'attachment_type' => CommentAttachment::class, 'created_at' => $itemCommentAttachment->created_at,  'updated_at' => $itemCommentAttachment->updated_at]);
                    Attachment::firstOrCreate(['url' => $itemCommentAttachment->url, 'attachmentable_id' => $itemCommentAttachment->comment_id, 'attachmentable_type' => Comment::class]);
                }
            } else {
                $flag++;
                $this->info("Se creo la tabla Attachment en base de datos.");
                Schema::create('attachments', function (Blueprint $table) {
                    $table->id();
                    //Aqui tuve un error
                    // $table->foreignId('attachment_id')->unsignedBigInteger();
                    // $table->string('attachment_type');
                    $table->morphs('attachmentable');
                    $table->string('url');
                    $table->timestamps();
                });
            }
        } while (!$ifExist);

        switch ($flag) {
            case 1:
                $this->info("Se ha migrado la informacion exitosamente.");
                break;

            case 2:
                $this->info("Se ha creado la tabla y migrado la informacion exitosamente.");
                break;

            default:
                $this->info("Ha ocurrido un error en la ejecución.");
                return 1;
                break;
            }
        return 0;
    }
}
