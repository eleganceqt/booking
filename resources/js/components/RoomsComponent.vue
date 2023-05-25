<template>

    <div class="row">
        <br>
        <br>
        <h2 class="ui dividing center aligned header">Search Rooms</h2>

        <div class="ui form">
            <div class="fields">
                <div class="six wide field">
                    <label>Check-in Date</label>
                    <input type="date" name="checkin_date" v-model="checkinDate">
                </div>
                <div class="four wide field">
                    <label>Nights</label>
                    <input type="number" name="nights" min="1" v-model="nights">
                </div>
                <div class="four wide field">
                    <label>Number of Persons</label>
                    <input type="number" name="persons" min="1" max="4" v-model="persons">
                </div>
                <div class="two wide field">
                    <label> &nbsp; </label>
                    <button class="ui right labeled icon button" :class="{'loading': submitting}" @click="onSearch">
                        <i class="right arrow icon"></i>
                        Next
                    </button>
                </div>
            </div>
        </div>


        <div class="ui divided items" style="padding-top: 2em" v-if="rooms.length">
            <div class="item" v-for="room in rooms">
                <div class="image">
                    <img src="https://fomantic-ui.com/images/wireframe/image.png">
                </div>
                <div class="content">
                    <a class="header">Room #{{ room.id }}</a>
                    <div class="description">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A eaque explicabo id minima quas
                            ratione sed soluta! Ad assumenda, at ea ex, excepturi exercitationem illum neque, pariatur
                            placeat quasi unde!</p>
                    </div>
                    <div class="extra">
                        <div class="ui label"><i class="user friends icon"></i>Number of Persons:
                            <strong>{{ room.occupancy }}</strong></div>
                        <div class="ui fluid basic styled accordion">
                            <div class="title">
                                <i class="dropdown icon"></i>
                                Make Reservation?
                            </div>
                            <div class="content">
                                <div class="ui form">
                                    <div class="fields">
                                        <div class="five wide field">
                                            <label>Name</label>
                                            <input type="text" autocomplete="off" v-model="guest.name">
                                        </div>
                                        <div class="four wide field">
                                            <label>Email</label>
                                            <input type="text" autocomplete="off" v-model="guest.email">
                                        </div>
                                        <div class="four wide field">
                                            <label>Phone</label>
                                            <input type="text" autocomplete="off" v-model="guest.phone">
                                        </div>
                                        <div class="one wide field">
                                            <label> &nbsp; </label>
                                            <button class="ui primary button" @click="onReserve(room.id)">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
export default {
    name: "RoomsComponent",

    data: function () {
        return {
            submitting: false,
            checkinDate: null,
            nights: 1,
            persons: 1,
            guest: {
                name: null,
                email: null,
                phone: null
            },
            rooms: [],
        }
    },

    methods: {
        onSearch() {

            if (this.submitting) {
                return;
            }

            this.submitting = true;

            axios
                .get('/rooms/search', {
                    params: {
                        checkin_date: this.checkinDate,
                        nights: this.nights,
                        persons: this.persons,
                    }
                })
                .then(response => {
                    this.rooms = response.data;
                })
                .then(() => {
                    console.log($('.ui.accordion'))
                    $('.ui.accordion')
                        .accordion()
                    ;
                })
                .finally(() => {
                    this.submitting = false;
                })
        },

        onReserve(room) {

            axios
                .post(`/reservations/${room}`, {
                    checkin_date: this.checkinDate,
                    nights: this.nights,
                    persons: this.persons,
                    user: this.guest
                })
                .then(response => {
                    // @todo: show error when not reserved

                    // @todo: clear all forms and rooms list
                });
        }
    }
}
</script>

<style scoped>

</style>
