<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';

type ButtonVariant = 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
type ButtonSize = 'default' | 'sm' | 'lg' | 'icon';

defineProps<{
    dialog: string;
    dialogClass?: string;
    title: string;
    description: string;
    variant?: ButtonVariant;
    size?: ButtonSize;
    event: () => void;
}>();
</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger as-child>
            <Button :variant="variant" :size="size">{{ dialog }}</Button>
        </AlertDialogTrigger>
        <AlertDialogContent
            class="sm:max-w-md"
            @interact-outside="
                (event) => {
                    const target = event.target as HTMLElement;
                    if (target?.closest('[data-sonner-toaster]')) return event.preventDefault();
                }
            "
        >
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
                <AlertDialogDescription>
                    {{ description }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel variant="secondary">Batal</AlertDialogCancel>
                <AlertDialogAction
                    :class="dialogClass"
                    @click="
                        () => {
                            event();
                        }
                    "
                    >Kirim</AlertDialogAction
                >
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
