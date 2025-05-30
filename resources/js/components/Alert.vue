<script setup lang="ts">
import { Button } from '@/components/ui/button';
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
} from '@/components/ui/alert-dialog'
import { toast } from 'vue-sonner';

defineProps<{
    dialog: string;
    title: string;
    description: string;
    info: string;
    event: () => void;
}>();
</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger as-child>
            <Button>{{ dialog }}</Button>
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
                    @click="
                        () => {
                            event();
                            toast.success(info);
                        }
                    "
                    >Kirim</AlertDialogAction
                >
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
