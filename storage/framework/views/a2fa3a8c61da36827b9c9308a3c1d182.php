<?php
    use Illuminate\Support\Arr;
    $editPropertiesAction = $getAction($getCustomPropertiesActionName()) ;

?>

<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => $getFieldWrapperView()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field' => $field,'label-sr-only' => $isLabelHidden()]); ?>
    <div
        <?php if(\Filament\Support\Facades\FilamentView::hasSpaMode()): ?>
            ax-load="visible"
        <?php else: ?>
            ax-load
        <?php endif; ?>
        ax-load-src="<?php echo e(\Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc("gallery-json-media","webplusm/gallery-json-media")); ?>"
        x-load-css="[<?php echo \Illuminate\Support\Js::from(\Filament\Support\Facades\FilamentAsset::getStyleHref("gallery-json-media-styles","webplusm/gallery-json-media"))->toHtml() ?>]"
        x-data="galleryFileUpload({
                     state : $wire.$entangle('<?php echo e($getStatePath()); ?>'),
                     statePath : <?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>,
                     minSize : <?php echo \Illuminate\Support\Js::from($getMinSize())->toHtml() ?> ,
                     maxSize : <?php echo \Illuminate\Support\Js::from($getMaxSize())->toHtml() ?>,
                     maxFiles : <?php echo \Illuminate\Support\Js::from($getMaxFiles())->toHtml() ?>,
                     isReorderable: <?php echo \Illuminate\Support\Js::from($isReorderable())->toHtml() ?>,
                     isDeletable: <?php echo \Illuminate\Support\Js::from($isDeletable())->toHtml() ?>,
                     isDisabled: <?php echo \Illuminate\Support\Js::from($isDisabled)->toHtml() ?>,
                     isDownloadable: <?php echo \Illuminate\Support\Js::from($isDownloadable())->toHtml() ?>,
                     hasCustomPropertiesAction : <?php echo \Illuminate\Support\Js::from($hasCustomPropertiesAction())->toHtml() ?> ,
                     isMultiple : <?php echo \Illuminate\Support\Js::from($isMultiple())->toHtml() ?>,
                     acceptedFileTypes : <?php echo \Illuminate\Support\Js::from($getAcceptedFileTypes())->toHtml() ?>,
                     uploadingMessage: <?php echo \Illuminate\Support\Js::from($getUploadingMessage())->toHtml() ?>,
                     changeNameToAlt : <?php echo \Illuminate\Support\Js::from($hasNameReplaceByTitle())->toHtml() ?>,
                     removeUploadedFileUsing: async (fileKey) => {
                        return await $wire.removeFormUploadedFile(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>, fileKey)
                    },
                     deleteUploadedFileUsing: async (fileKey) => {
                        return await $wire.deleteUploadedFile(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>, fileKey)
                    },
                    getUploadedFilesUsing: async () => {
                        return await $wire.getFormUploadedFiles(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>)
                    },
                    reorderUploadedFilesUsing: async (files) => {
                        return await $wire.reorderFormUploadedFiles(<?php echo \Illuminate\Support\Js::from($getStatePath())->toHtml() ?>, files)
                    },
                    customPropertyActionName : <?php echo \Illuminate\Support\Js::from($getCustomPropertiesActionName())->toHtml() ?>,

         })"
        wire:ignore
        x-ignore
        class="grid gap-y-2 "
        x-id="['file-input']"
    >
        <input type="file" :id="$id('file-input')"
               x-bind="laFileInput"
               x-ref="laFileInput"
               class="hidden"
               <?php echo e($isMultiple()?'multiple':''); ?>

               <?php echo e($isDisabled()?'disabled':''); ?>

               accept="<?php echo e(implode(',',Arr::wrap($getAcceptedFileTypes()))); ?>"
        >
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            "wm-json-media-dropzone flex items-center justify-center w-full py-3 border border-dashed rounded-lg border-gray-300  text-gray-400 transition
    hover:border-primary-400 dark:border-gray-400/50 dark:bg-gray-800 dark:hover:border-primary-600 dark:text-white/80",
        ]); ?>"
             :class="{'pointer-events-none opacity-40' : startUpload}"
             role="button"
             x-ref="dropzone"
             x-cloak
             x-bind="dropZone"
             x-show="canUpload"
        >
            <div class="flex gap-3 pointer-events-none" x-ref="ladroptitle">
                <?php echo e(svg(name: 'heroicon-o-document-arrow-up',class:"w-10 h-auto text-slate-500")); ?>
                <div class="flex flex-col x-space-y-2">
                    <span><?php echo e(trans('gallery-json-media::gallery-json-media.Drag&Drop')); ?></span>
                    <span x-text="<?php echo \Illuminate\Support\Js::from($getAcceptFileText())->toHtml() ?>"></span>
                </div>
            </div>
        </div>
        <div class="flex justify-self-end space-y-2"
            x-show="uploadFiles.length"
        >
            <div class="flex gap-x-4 mt-2">
                <button type="button" x-bind="leftArrow"
                        class="wm-btn"
                >
                    <?php echo e(svg(name: 'heroicon-c-chevron-left',class: 'w-5 h-5')); ?>
                </button>
                <button type="button" x-bind="rightArrow"
                        class="wm-btn"
                >
                    <?php echo e(svg(name: 'heroicon-c-chevron-right',class: 'w-5 h-5')); ?>
                </button>
            </div>
        </div>

        <div class="gallery-file-upload-wrapper "
             x-ref="galleryImages"
             x-bind="onScrolling"
        >
            <ul role="list"
                class="flex gap-2 transition-all duration-200"
                @keydown.window.tab="usedKeyboard = true"
                @dragenter.stop.prevent="dropcheck++"
                @dragleave="dropcheck--;dropcheck || rePositionPlaceholder()"
                @dragover.stop.prevent
                @dragend="revertState()"
                @drop.stop.prevent="getSort();resetState()"
                x-ref="ulGalleryWrapper"
                
            >
               <?php echo $__env->make('gallery-json-media::forms.content.gallery-content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php /**PATH /Users/noamany/Desktop/untitled folder 2/projects/MuGaber/7aseeb/Formado Admin panel/resources/views/vendor/gallery-json-media/forms/gallery-file-upload.blade.php ENDPATH**/ ?>