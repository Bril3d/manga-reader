    <?php

    namespace App\Jobs;

    use App\Models\Manga;
    use App\Models\Chapter;
    use Illuminate\Bus\Queueable;
    use App\Helpers\ChapterHelper;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Contracts\Queue\ShouldBeUnique;

    class ProcessChapterJob implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        protected $folder;
        protected $mangaSlug;
        protected $chapterNumber;

        /**
         * Create a new job instance.
         */
        public function __construct($folder, $mangaSlug, $chapterNumber)
        {
            $this->folder = $folder;
            $this->mangaSlug = $mangaSlug;
            $this->chapterNumber = $chapterNumber;
        }

        /**
         * Execute the job.
         */
        public function handle()
        {
            $chapterNumber = basename($this->folder);
            if ($chapterNumber === 'random') {
                $failedFolders[] = $chapterNumber;
                return;
            }

            // Retrieve the manga by slug
            $manga = Manga::where('slug', $this->mangaSlug)->first();
            if (!$manga) {
                $failedFolders[] = $chapterNumber;
                return;
            }

            $chapterData = $manga->chapters()->where('chapter_number', $chapterNumber)->first();
            if ($chapterData) {
                $failedFolders[] = $chapterNumber;
                return;
            }

            $extractedImages = ChapterHelper::extractImagesFromFolder($this->folder, $this->mangaSlug, $chapterNumber);
            $chapterData = [
                'content' => $extractedImages,
                'manga_id' => $manga->id,
                'chapter_number' => $chapterNumber,
                'user_id' => auth()->id(),
            ];

            Chapter::create($chapterData);
        }
    }
