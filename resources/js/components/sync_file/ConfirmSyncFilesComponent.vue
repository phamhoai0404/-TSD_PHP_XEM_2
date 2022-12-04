<template>
    <v-dialog
      v-model="isOpen"
      max-width="320"
    >
        <v-card id="confirm">
            <v-card-title class="headline">{{ $t('message.alert.confirm') }}</v-card-title>
            <v-card-text>
                {{ $t('message.sync_file.confirm_sync') }}
                <slot></slot>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="green darken-1"
                  flat="flat"
                  @click="$emit('agree', true)"
                >
                    {{ $t('message.alert.accept') }}
                </v-btn>

                <v-btn
                  color="red darken-1"
                  flat="flat"
                  @click="$emit('agree', false)"
                >
                    {{ $t('message.alert.donot') }}
                </v-btn>
             </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default{
    name: 'ConfirmSync',
    data() {
      return {
          isOpen: true
          }
    },
    watch: {
      isOpen() {
        this.$emit('close');
        }
    }
}
</script>
<style >
</style>