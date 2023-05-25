<template>
    <div class="row">
        <br>
        <br>

        <h2 class="ui dividing center aligned header">Reservations</h2>

        <div class="ui form">
            <div class="fields">
                <div class="seven wide field">
                    <label>Check-in Date</label>
                    <input type="date" name="checkin_date" v-model="checkinDate">
                </div>
                <div class="seven wide field">
                    <label>Check-out Date</label>
                    <input type="date" name="checkin_date" v-model="checkoutDate">
                </div>
                <div class="two wide field">
                    <label> &nbsp; </label>
                    <button class="ui button" @click="onSearch">
                        Search
                    </button>
                </div>
            </div>
        </div>

        <div class="ui horizontal fluid one cards" v-if="reservations.length">
            <div class="fluid card" v-for="reservation in reservations">
                <div class="image">
                    <img src="https://fomantic-ui.com/images/wireframe/image.png">
                </div>
                <div class="content">
                    <div class="header">Reservation #{{reservation.id }}
                        <span class="ui grey text">
                            (Room {{ reservation.room.id }})
                        </span>
                    </div>
                    <div class="description">

                        <div class="ui text" style="margin-bottom: 0.1em">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur, assumenda libero magnam magni modi nam necessitatibus.
                        </div>

                        <div class="ui label">
                            <i class="calendar alternate icon"></i>Checkin Date:
                            <strong>{{ reservation.checkin_date }}</strong>
                        </div>
                        <div class="ui label">
                            <i class="calendar alternate icon"></i>Checkout Date:
                            <strong>{{ reservation.checkout_date }}</strong>
                        </div>
                        <div class="ui label">
                            <i class="user friends icon"></i>Occupancy:
                            <strong>{{ reservation.room.occupancy }}</strong>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "Reservations",

    data: function () {
        return {
            checkinDate: null,
            checkoutDate: null,
            reservations: [],
        }
    },

    methods: {
        onSearch() {

            axios
                .get('/admin/reservations/search', {
                    params: {
                        checkin_date: this.checkinDate,
                        checkout_date: this.checkoutDate,
                    }
                })
                .then(response => {
                    this.reservations = response.data;
                });

        }
    }
}
</script>

<style scoped>

</style>
