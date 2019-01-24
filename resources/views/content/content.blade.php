    @extends('main')
    @section('content')
        <template v-if="menu==0">
            <h1>Menu 0 Content</h1>
        </template>
        
        <template v-if="menu==1">
            <category></category>
        </template>

        <template v-if="menu==2">
            <item></item>
        </template>

        <template v-if="menu==3">
            <h1>Menu 3 Content</h1>
        </template>

        <template v-if="menu==4">
            <h1>Menu 4 Content</h1>
        </template>

        <template v-if="menu==5">
            <h1>Menu 5 Content</h1>
        </template>

        <template v-if="menu==6">
            <h1>Menu 6 Content</h1>
        </template>

        <template v-if="menu==7">
            <h1>Menu 7 Content</h1>
        </template>

        <template v-if="menu==8">
            <h1>Menu 8 Content</h1>
        </template>

        <template v-if="menu==9">
            <h1>Menu 9 Content</h1>
        </template>

        <template v-if="menu==10">
            <h1>Menu 10 Content</h1>
        </template>

        <template v-if="menu==11">
            <h1>Menu 11 Content</h1>
        </template>

        <template v-if="menu==12">
            <h1>Menu 12 Content</h1>
        </template>


    @endsection
        